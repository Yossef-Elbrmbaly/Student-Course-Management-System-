<?php

namespace App\Contracts;

interface CourseRepositoryInterface
{
    public function getAll(): array;

    public function getById(int $id): ?array;

    public function create(string $name, string $code): bool;

    public function update(int $id, string $name, string $code): bool;

    public function delete(int $id): bool;
}
