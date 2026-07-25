<?php

namespace App\Middleware;

use App\Core\Csrf;
use App\Core\Request;
use App\Exceptions\InvalidMethodException;
use App\Exceptions\ValidationException;

class CsrfMiddleware
{
    public static function handle(): void
    {
        if (Request::method() !== 'POST') {
            throw new InvalidMethodException('Only POST requests are allowed.');
        }

        if (!Csrf::verify(Request::input('_token'))) {
            throw new ValidationException('Invalid CSRF token.');
        }
    }
}