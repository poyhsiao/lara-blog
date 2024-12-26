<?php

namespace App\Repositories;

use App\Foundation\Helper\HashidTools;
use App\Foundation\Helper\QrCodeTools;
use App\Helper\JsonResponseHelper;
use App\Mail\ForgetPasswordMail;
use App\Mail\UserEmailVerify;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthRepository extends BaseRepository
{
    protected $model;

    protected $hash;

    public function __construct(User $model, HashidTools $hashids)
    {
        $this->model = $model;
        $this->hash = $hashids->connection('email-validate');
    }

    /**
     * Register a new user.
     *
     * Attempts to create a new user in the database and sends a verification email.
     * If successful, returns the created user, a JWT token, and the token type.
     * In case of failure, logs the error and returns a JSON response with an error message.
     *
     * @param array $data The data for creating a new user.
     * @return array|JsonResponse An array containing the user, token, and type on success,
     *                            or a JsonResponse with an error message on failure.
     */
    public function register(array $data): array|JsonResponse
    {
        $user = null;

        try {
            DB::transaction(function () use ($data, &$user) {
                $user = $this->model::create($data);

                /**
                 * Send verification email
                 */
                $this->sendVerificationEmail($user);
            });

            /**
             * Add token
             */
            $token = JWTAuth::fromUser($user);
            $type = 'Bearer';

            return compact('user', 'token', 'type');
        } catch (\Exception $e) {
            Log::error('Register failed', [
                'data' => $data,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Register failed');
        }
    }

    /**
     * Login a user.
     *
     * Attempts to login a user with the given credentials, and returns the user, a JWT token, and the token type.
     * If the user is not active or the email is not verified, returns a JSON response with a 401 status.
     * If the login fails, logs the error and returns a JSON response with an error message.
     *
     * @param array $data The data for logging in a user.
     * @return array|JsonResponse An array containing the user, token, and type on success,
     *                            or a JsonResponse with an error message on failure.
     */
    public function login(array $data): array|JsonResponse
    {
        try {
            $username = $data['user'];
            $password = $data['password'];

            $token = JWTAuth::attempt([
                'email' => $username,
                'password' => $password,
            ]) ?: JWTAuth::attempt([
                'name' => $username,
                'password' => $password,
            ]);

            if (!$token) {
                return JsonResponseHelper::unauthorized('Login failed');
            }

            $authenticatedUser = Auth::user();
            $tokenType = 'Bearer';

            if ($authenticatedUser->active !== 1 || $authenticatedUser->email_verified_at === null) {
                return JsonResponseHelper::unauthorized('The user is not active or email is not verified');
            }

            return compact('authenticatedUser', 'token', 'tokenType');
        } catch (Throwable $exception) {
            Log::error('Login failed', [
                'data' => $data,
                'message' => $exception->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Login failed');
        }
    }

    public function emailVerification(array $validated)
    {
        $result = null;

        try {
            $userId = $this->hash->decode($validated['u'])[0];

            DB::transaction(function () use ($userId, &$result) {
                $result = $this->model::find($userId);
                $result->email_verified_at = now();
                $result->save();
            });
        } catch (\Exception $e) {
            Log::error('Email verification failed', [
                'validated' => $validated,
                'message' => $e->getMessage(),
            ]);
        }
        return $result;
    }

    public function forgetPassword(array $validated): array|JsonResponse
    {
        $result = null;

        try {
            $theUser = $validated['user'];

            $user = $this->model::where('email', $theUser)
            ->orWhere('name', $theUser)->first();

            if (!$user) {
                return JsonResponseHelper::error('User not found');
            }

            $code = $this->generatePasswordQrCode($user);

            $this->sendForgetPasswordEmail($user, $code['url'], $code['image']);

            return ['url' => $code['url']];
        } catch (Throwable $e) {
            Log::error('Forget password failed', [
                'data' => [
                    'user' => $validated['user'],
                    'message' => $e->getMessage(),
                ],
            ]);
            return JsonResponseHelper::error(null, 'Forget password failed');
        }
    }

    private function verifyEmailContent(User|Authenticatable $user): string
    {
        $encode = [
            'user_id' => $this->hash->encode($user->id),
            'exp' => $this->hash->encode(now()->addDays(7)->timestamp),
        ];

        $url = config('app.url') . '/api/v1/verify-email/' .
        '?u=' . $encode['user_id'] . '&p=' . $encode['exp'];

        return 'Please verify your email by linking ( ' . $url . ' )';
    }

    private function generatePasswordQrCode(User|Authenticatable $user): array
    {
        $encode = [
            'user_id' => $this->hash->encode($user->id),
            'exp' => $this->hash->encode(now()->addDays(7)->timestamp),
        ];

        $url = sprintf('%s/api/v1/reset-password/?u=%s&p=%s', config('app.url'), $encode['user_id'], $encode['exp']);

        $qrCode = new QrCodeTools($url);
        $qrCode->textType = 'url';
        $qrCode->fileType = 'svg';

        ob_start();
        $qrCode->generate();
        $image = ob_get_clean();

        return compact('url', 'image');
    }

    private function sendVerificationEmail(User|Authenticatable $user): ?string
    {
        return Mail::to($user->email)->send(new UserEmailVerify($user, $this->verifyEmailContent($user)));
    }

    private function sendForgetPasswordEmail(User|Authenticatable $user, $url, $qrcode): ?string
    {
        return Mail::to($user->email)->send(new ForgetPasswordMail($user, $url, $qrcode));
    }
}
