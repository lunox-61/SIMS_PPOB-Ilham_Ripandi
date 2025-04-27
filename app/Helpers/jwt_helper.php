<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

if (! function_exists('generate_jwt')) {
    function generate_jwt($payload)
    {
        $secretKey = env('JWT_SECRET');
        $issuedAt = time();
        $expirationTime = $issuedAt + env('JWT_EXPIRATION');
        $issuer = env('JWT_ISSUER');
        $audience = env('JWT_AUDIENCE');

        $payload = array_merge($payload, [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'iss' => $issuer,
            'aud' => $audience,
        ]);

        return JWT::encode($payload, $secretKey, 'HS256');
    }
}

if (! function_exists('decode_jwt')) {
    function decode_jwt($jwt)
    {
        try {
            $secretKey = env('JWT_SECRET');
            return JWT::decode($jwt, new Key($secretKey, 'HS256'));
        } catch (Exception $e) {
            return null; // Token invalid atau expired
        }
    }
}
