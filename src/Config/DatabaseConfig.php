<?php

namespace App\Config;

class DatabaseConfig
{
    public function host(): string
    {
        return $_ENV['DB_HOST'];
    }

    public function port(): string
    {
        return $_ENV['DB_PORT'];
    }

    public function database(): string
    {
        return $_ENV['DB_NAME'];
    }

    public function username(): string
    {
        return $_ENV['DB_USER'];
    }

    public function password(): string
    {
        return $_ENV['DB_PASS'];
    }
}
