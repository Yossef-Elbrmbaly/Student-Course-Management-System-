<?php

namespace App\Contracts;

interface StudentRepositoryInterface
{
    public function getAll(): array;

    public function getById(int $id): ?array;

    public function create(string $name, string $email, string $phone, int $department_id): bool;

    public function update(int $id, string $name, string $email, string $phone, int $department_id): bool;

    public function delete(int $id): bool;
}
