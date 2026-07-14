<?php

namespace App\Contracts;

interface DepartmentRepositoryInterface
{
    public function getAll(): array;

    public function getById(int $id): ?array;

    public function create(string $name): bool;

    public function update(int $id, string $name): bool;

    public function delete(int $id): bool;
}
