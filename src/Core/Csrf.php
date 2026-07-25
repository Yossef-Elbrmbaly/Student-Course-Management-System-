<?php

namespace App\Core;

class Csrf
{
    public static function generate(): string
    {
        if (!isset($_SESSION['_token'])) {
            $_SESSION['_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['_token'];
    }

    public static function verify(?string $token): bool
    {
        return isset($_SESSION['_token'])
            && hash_equals($_SESSION['_token'], $token ?? '');
    }
}
