<?php

namespace App\Core;

abstract class BaseController
{
    protected function redirect(string $url = 'index.php'): void
    {
        header("Location: $url");
        exit;
    }

    protected function view(string $view, array $data = []): void
    {
        extract($data);
        require_once __DIR__ . "/../views/$view.php";
    }
}
