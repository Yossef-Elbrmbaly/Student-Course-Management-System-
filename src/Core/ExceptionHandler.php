<?php

namespace App\Core;

use Throwable;

class ExceptionHandler
{
    public static function handle(Throwable $exception): void
    {
        $debug = filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN);

        if ($exception instanceof ValidationException) {
            http_response_code(400);
            echo '<h2>Validation Error</h2>';
        } elseif ($exception instanceof NotFoundException) {
            http_response_code(404);
            echo '<h2>Not Found</h2>';
        } else {
            http_response_code(500);
            echo '<h2>Internal Server Error</h2>';
        }


        if ($debug) {
            echo '<pre>';
            echo $exception->getMessage();
            echo '</pre>';
        }

        exit;
    }
}
