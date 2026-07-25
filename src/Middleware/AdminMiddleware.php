<?php

namespace App\Middleware;

use App\Core\Auth;

class AdminMiddleware
{
    public static function handle(): void
    {
        if (!Auth::check()) {
            header('Location: index.php?page=auth&action=login');
            exit;
        }

        if (!Auth::isAdmin()) {
            throw new UnauthorizedException('You are not authorized to access this page.');
        }
    }
} 