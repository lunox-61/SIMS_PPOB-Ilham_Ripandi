<?php

namespace App\Helpers;

class JwtHelper
{
    public static function generateSecret($length = 64)
    {
        $bytes = random_bytes($length);
        $secret = rtrim(strtr(base64_encode($bytes), '+/', '-_'), '=');
        return $secret;
    }
}

// Untuk penggunaan cepat di CLI
if (php_sapi_name() === 'cli') {
    echo "JWT Secret: " . JwtHelper::generateSecret(64) . PHP_EOL;
}
