<?php

namespace App\Repositories;

use App\Contracts\DepartmentRepositoryInterface;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use PDO;
use PDOException;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    public function __construct(private PDO $connection)
    {
    }

    public function getAll(): array
    {
        $query = 'SELECT * FROM departments ORDER BY id';
        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        if ($id <= 0) {
            throw new ValidationException('Invalid department ID provided.');
        }

        $query = 'SELECT * FROM departments WHERE id = :id';
        $stmt = $this->connection->prepare($query);
        $stmt->execute(['id' => $id]);

        $department = $stmt->fetch();

        if (!$department) {
            throw new NotFoundException("Department with ID {$id} not found.");
        }

        return $department;
    }

    public function create(string $name): bool
    {
        if (empty($name)) {
            throw new ValidationException('Department name is required.');
        }

        try {
            $query = 'INSERT INTO departments (name) VALUES (:name)';
            $stmt = $this->connection->prepare($query);

            return $stmt->execute(['name' => $name]);

        } catch (PDOException $e) {
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode === 1062) {
                throw new ValidationException('Department name already exists.');
            }
            throw $e;
        }
    }

    public function update(int $id, string $name): bool
    {
        if ($id <= 0 || empty($name)) {
            throw new ValidationException('Invalid department data provided.');
        }

        $this->getById($id);

        $query = 'UPDATE departments SET name = :name WHERE id = :id';
        $stmt = $this->connection->prepare($query);

        return $stmt->execute([
            'id' => $id,
            'name' => $name,
        ]);
    }

    public function delete(int $id): bool
    {
        $this->getById($id);

        $query = 'DELETE FROM departments WHERE id = :id';
        $stmt = $this->connection->prepare($query);

        return $stmt->execute(['id' => $id]);
    }
}
