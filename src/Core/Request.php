<?php

namespace App\Core;

class Request
{
    public static function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function query(string $key, mixed $default = null): mixed
    {
        return $_GET[$key] ?? $default;
    }

    public static function queryInt(string $key): int
    {
        return (int) (self::query($key, 0));
    }

    public static function input(string $key, mixed $default = ''): mixed
    {
        $value = $_POST[$key] ?? $default;

        return is_string($value)
            ? trim($value)
            : $value;
    }

    public static function inputInt(string $key): int
    {
        return (int) self::input($key, 0);
    }

}
