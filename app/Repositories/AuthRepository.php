<?php

namespace App\Repositories;

use App\Foundation\Helper\HashidTools;
use App\Mail\UserEmailVerify;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
     * User create
     *
     * @param array $data
     * @return User|null
     */
    public function create(array $data): ?User
    {
        $user = null;

        try {
            DB::transaction(function () use ($data, &$user) {
                $user = $this->model
                  ->create($data);

                $this->sendVerificationEmail($user);
            });
        } catch (\Exception $e) {
            return null;
        }

        return $user;
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

    private function sendVerificationEmail(User|Authenticatable $user): ?string
    {
        return Mail::to($user->email)->send(new UserEmailVerify($user, $this->verifyEmailContent($user)));
    }
}
