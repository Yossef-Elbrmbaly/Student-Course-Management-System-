<?php

namespace App\Contracts;

interface UserRepositoryInterface
{
    public function create(
        int $studentId,
        string $email,
        string $password,
        string $role
    ): bool;

    public function getByEmail(string $email): ?array;
}
