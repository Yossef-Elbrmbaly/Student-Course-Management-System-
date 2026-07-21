<?php

namespace App\Config;

class DatabaseConfig
{
    public function host(): string
    {
        return $getenv['DB_HOST'];
    }

    public function port(): string
    {
        return $getenv['DB_PORT'];
    }

    public function database(): string
    {
        return $getenv['DB_NAME'];
    }

    public function username(): string
    {
        return $getenv['DB_USER'];
    }

    public function password(): string
    {
        return $getenv['DB_PASS'];
    }
}
