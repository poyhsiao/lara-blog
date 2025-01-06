<?php

namespace App\Repositories;

use App\Helper\JsonResponseHelper;
use App\Mail\ForgetPasswordMail;
use App\Mail\UserEmailVerifyMail;
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

    private const USER_NOT_FOUND_ERROR = 'User not found';

    public function __construct(User $model)
    {
        $this->model = $model;
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
        $code = $this->generateOneTimePassword();
        $data['email_validate_token'] = $this->validationFormat($code, now()->addMinutes(config('misc.one_time_password.ttl', 5))->timestamp);

        $response = null;

        try {
            $user = null;

            DB::transaction(function () use ($code, $data, &$user) {
                $user = $this->model::create($data);

                /**
                 * Send verification email
                 */
                $this->sendVerificationEmail($user, $code);
            });

            $response = $user?->toArray();
        } catch (Throwable $e) {
            Log::error('Register failed', [
                'data' => $data,
                'message' => $e->getMessage(),
            ]);
            $response = JsonResponseHelper::error(null, 'Register failed');
        }

        return $response;
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
                return $this->handleLoginError(self::LOGIN_FAILED_ERROR);
            }

            $user = Auth::user();
            $tokenType = 'Bearer';

            if ($user->active !== 1 || $user->email_verified_at === null) {
                return $this->handleLoginError('The user is not active or email is not verified');
            }

            $response = compact('user', 'token', 'tokenType');
        } catch (Throwable $exception) {
            Log::error(self::LOGIN_FAILED_ERROR, [
                'data' => $data,
                'message' => $exception->getMessage(),
            ]);
            $response = JsonResponseHelper::error(null, self::LOGIN_FAILED_ERROR);
        }

        return $response;
    }

    /**
     * Verifies a user's email.
     *
     * Attempts to verify a user with the given code, and returns the user, a JWT token, and the token type.
     * If the user is not found or the code is invalid/expired, logs the error and returns a JSON response with an error message.
     * If the verification fails, logs the error and returns a JSON response with an error message.
     *
     * @param array $validated The validated data for verifying a user.
     * @return array|JsonResponse An array containing the user, token, and type on success, or a JsonResponse with an error message on failure.
     */
    public function emailVerification(array $validated): array|JsonResponse
    {
        $user = $validated['user'];
        $code = $validated['code'];

        try {
            $user = $this->model::where('name', $user)
                ->orWhere('email', $user)
                ->whereNotNull('email_validate_token')
                ->first();

            if ($user) {
                [$theCode, $expire] = $user->email_validate_token;

                if ($code === $theCode && $expire >= now()->timestamp) {
                    DB::transaction(function () use (&$user) {
                        $user->email_verified_at = now();
                        $user->email_validate_token = null;
                        $user->save();
                    });

                    $token = JWTAuth::fromUser($user);
                    $type = 'Bearer';

                    return compact('user', 'token', 'type');
                }
            }

            return JsonResponseHelper::error(null, 'Invalid code or code expired');
        } catch (Throwable $e) {
            Log::error('Email verification failed', [
                'validated' => $validated,
                'message' => $e->getMessage(),
            ]);
            return self::handleLoginError('Email verification failed');
        }
    }

    /**
     * Handle the forget password process for a user.
     *
     * Searches for a user by email or name provided in the validated array.
     * If the user is found, generates a one-time password and expiration timestamp,
     * saves the reset password token to the user's record, and sends a forget password
     * email with the generated code. Returns the user's data on success.
     * Logs an error and returns a JSON response with an error message if the process fails.
     *
     * @param array $validated An associative array containing the 'user' key with the user's email or name.
     * @return array|JsonResponse The user's data as an array on success, or a JsonResponse with an error message on failure.
     */
    public function forgetPassword(array $validated): array|JsonResponse
    {
        try {
            $theUser = $validated['user'];

            $user = $this->model::where('email', $theUser)
            ->orWhere('name', $theUser)->first();

            if (!$user) {
                return JsonResponseHelper::error(self::USER_NOT_FOUND_ERROR);
            }

            DB::transaction(function () use (&$user) {
                $expire = now()->addMinutes(config('misc.one_time_password.ttl', 5))->timestamp;
                $code = $this->generateOneTimePassword();

                $user->reset_password_token = $this->validationFormat($code, $expire);
                $user->save();

                $this->sendForgetPasswordEmail($user, $code);
            });

            return $user->toArray();
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

    /**
     * Reset the password for a user.
     *
     * Searches for a user by email or name provided in the validated array,
     * and checks if the user has a valid reset password token and if the code
     * matches the one in the token. If the check is successful, returns the user's
     * data as an array. If the user is not found, the code is invalid, or the
     * code has expired, returns a JSON response with an error message.
     *
     * @param array $validated An associative array containing the 'user' and 'code' keys.
     * @return array|JsonResponse The user's data as an array on success, or a JsonResponse with an error message on failure.
     */
    public function resetPassword(array $validated): array|JsonResponse
    {
        $user = $validated['user'];
        $code = $validated['code'];

        if (!$user = $this->model::where('email', $user)
            ->orWhere('name', $user)
            ->whereNotNull('reset_password_token')
            ->first()) {
            return JsonResponseHelper::error(self::USER_NOT_FOUND_ERROR);
        }

        [$theCode, $expire] = $user->reset_password_token;

        if ($code !== $theCode || $expire < now()->timestamp) {
            return JsonResponseHelper::error('Invalid code or code expired');
        }

        return $user->toArray();
    }

    /**
     * Update the user's password.
     *
     * Searches for a user by email or name provided in the validated array,
     * and checks if the user has a valid reset password token. If the user is found,
     * hashes the new password, updates the user's password, and clears the reset password token.
     * Returns the updated user data as an array on success. Logs an error and returns a
     * JsonResponse with an error message if the user is not found or if an exception occurs.
     *
     * @param array $validated An associative array containing the 'user' and 'password' keys.
     * @return array|JsonResponse The updated user's data as an array on success, or a JsonResponse with an error message on failure.
     */
    public function newPassword(array $validated): array|JsonResponse
    {
        $user = $validated['user'];
        $password = $validated['password'];

        $user = $this->model::where('email', $user)
            ->orWhere('name', $user)
            ->whereNotNull('reset_password_token')
            ->first();

        if (!$user || !$user->isVerified() || $user->deleted_at) {
            return JsonResponseHelper::error(self::USER_NOT_FOUND_ERROR);
        }

        try {
            DB::transaction(function () use (&$user, $password) {
                $user->password = bcrypt($password);
                $user->reset_password_token = null;
                $user->save();
            });

            return $user->toArray();
        } catch (Throwable $e) {
            Log::error('New password failed', [
                'validated' => $validated,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'New password failed');
        }
    }

    /**
     * Resend the email verification for a user.
     *
     * Searches for a user by email or name provided in the validated array,
     * and checks if the user has a valid email verification token. If the user is found,
     * generates a new verification code and sends a verification email.
     * Returns the user's data as an array on success. Logs an error and returns a
     * JsonResponse with an error message if the user is not found or if an exception occurs.
     *
     * @param array $validated An associative array containing the 'user' and 'password' keys.
     * @return array|JsonResponse The user's data as an array on success, or a JsonResponse with an error message on failure.
     */
    public function reSendEmailVerify(array $validated): array|JsonResponse
    {
        $user = $validated['user'];
        $password = $validated['password'];

        try {
            $token = JWTAuth::attempt(['email' => $user, 'password' => $password]) ?: JWTAuth::attempt(['name' => $user, 'password' => $password]);

            if ($token) {
                /**
                 * @var User $user
                 */
                $user = Auth::user();

                if ($user->email_validate_token && $user->isActive() && !$user->deleted_at) {
                    $code = $this->generateOneTimePassword();
                    $emailValidateToken = $this->validationFormat($code, now()->addMinutes(config('misc.one_time_password.ttl', 5))->timestamp);

                    DB::transaction(function () use ($code, $emailValidateToken, &$user) {
                        $user->email_validate_token = $emailValidateToken;
                        $user->save();

                        $this->sendVerificationEmail($user, $code);
                    });

                    return $user->toArray();
                }
            }

            return JsonResponseHelper::error(null, self::INVALID_DATA_ERROR);
        } catch (Throwable $e) {
            Log::error('Resent email verification failed', [
                'validated' => $validated,
                'message' => $e->getMessage(),
            ]);
            return JsonResponseHelper::error(null, 'Resent email verification failed');
        }
    }

    /**
     * Generate a one-time password.
     *
     * Generates a random 7-digit string.
     *
     * @return string The generated one-time password.
     */
    private function generateOneTimePassword(): string
    {
        return str_pad((string) (hexdec(bin2hex(random_bytes(4))) % 10000000), 7, '0', STR_PAD_LEFT);
    }

    /**
     * Sends a verification email to the user.
     *
     * @param User|Authenticatable $user The user to send the email to.
     * @param string $code The verification code.
     * @return ?string The message ID of the sent email, or null if sending failed.
     */
    private function sendVerificationEmail(User|Authenticatable $user, string $code): ?string
    {
        return Mail::to($user->email)->send(new UserEmailVerifyMail($user, $code));
    }

    /**
     * Sends a forget password email to the user.
     *
     * @param User|Authenticatable $user The user to send the email to.
     * @param string $code The verification code.
     * @return ?string The message ID of the sent email, or null if sending failed.
     */
    private function sendForgetPasswordEmail(User|Authenticatable $user, string $code): ?string
    {
        return Mail::to($user->email)->send(new ForgetPasswordMail($code));
    }

    private function validationFormat(string $code, string $expire): string
    {
        return sprintf('%s-%s', $code, $expire);
    }

    private function handleLoginError(string $message): JsonResponse
    {
        return JsonResponseHelper::unauthorized($message);
    }
}
