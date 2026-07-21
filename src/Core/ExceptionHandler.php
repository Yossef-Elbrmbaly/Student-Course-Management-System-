<?php

namespace App\Core;

use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Exceptions\InvalidMethodException;
use Throwable;

class ExceptionHandler
{
    public static function handle(Throwable $exception): void
    {
        $debug = filter_var(getenv('APP_DEBUG') ?? false, FILTER_VALIDATE_BOOLEAN);

        [$statusCode, $title] = match (true) {
            $exception instanceof ValidationException => [400, 'Validation Error'],
            $exception instanceof NotFoundException => [404, 'Not Found'],
            $exception instanceof InvalidMethodException => [405, 'Method Not Allowed'],
            default => [500, 'Internal Server Error'],
        };

        http_response_code($statusCode);
        echo "<h2>{$title}</h2>";

        if ($debug) {
            echo '<pre>';
            echo $exception->getMessage();
            echo $exception->getTraceAsString();
            echo '</pre>';
        }

        exit;
    }
}
