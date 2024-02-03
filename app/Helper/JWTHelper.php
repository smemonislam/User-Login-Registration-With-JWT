<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHelper
{
    public static function CreateToken($id, $email)
    {
        $key = 'xyz-123-abc-321';
        $payload = [
            'iss' => 'laravel-demo',
            'iat' => time(),
            'exp' => time() * 60 * 60,
            'userId' => $id,
            'email' => $email,
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

    public static function DecodeToken($token)
    {
        try {
            if ($token == null) {
                return "unauthorized";
            } else {
                $key = "xyz-123-abc-321";
                return JWT::decode($token, new Key($key, 'HS256'));
            }

        } catch (Exception $exception) {
            return "unauthorized";
        }
    }
}