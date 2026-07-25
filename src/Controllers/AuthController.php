<?php

namespace App\Controllers;

use App\Contracts\UserRepositoryInterface;
use App\Core\Auth;
use App\Core\BaseController;
use App\Core\Request;
use App\Exceptions\InvalidMethodException;
use App\Exceptions\ValidationException;

class AuthController extends BaseController
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function login(): void
    {
        if (Auth::check()) {

            if (Auth::isAdmin()) {
                $this->redirect();
            }

            $this->redirect(
                'index.php?page=students&action=show&id=' . Auth::studentId()
            );
        }

        $this->view('auth/login');
    }

    public function authenticate(): void
    {
        if (Request::method() !== 'POST') {
            throw new InvalidMethodException('Only POST requests are allowed.');
        }

        $user = $this->userRepository->getByEmail(Request::input('email'));

        if (!$user || !password_verify(Request::input('password'), $user['password'])) {
            throw new ValidationException('Invalid email or password.');
        }

        Auth::login($user);
        if (Auth::isAdmin()) {
            $this->redirect();
        } elseif (Auth::isUser()) {
            $this->redirect(
                'index.php?page=students&action=show&id=' . Auth::studentId()
            );
        }
    }

    public function logout(): void
    {
        Auth::logout();

        $this
->redirect('index.php?page=auth&action=login');
    }
}
