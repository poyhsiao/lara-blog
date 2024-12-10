<?php

namespace App\Helper;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtHelper
{
    public static function createToken(string $user, string $password, string $userType = 'name'): ?string
    {
        try {
            $key = ('name' === $userType) ? 'name' : 'email';

            if (!$token = JWTAuth::attempt([
                $key => $user,
                'password' => $password
            ])) {
                return null;
            }

            return $token;
        } catch (JWTException $e) {
            return null;
        }
    }
}
