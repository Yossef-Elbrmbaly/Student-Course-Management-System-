<?php

namespace App\Repositories;

use App\Contracts\CourseRepositoryInterface;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use PDO;
use PDOException;

class CourseRepository implements CourseRepositoryInterface
{
    public function __construct(private PDO $connection)
    {
    }

    public function getAll(): array
    {
        $query = 'SELECT * FROM courses ORDER BY id';
        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        if ($id <= 0) {
            throw new ValidationException('Invalid course ID provided.');
        }

        $query = 'SELECT * FROM courses WHERE id = :id';
        $stmt = $this->connection->prepare($query);
        $stmt->execute(['id' => $id]);

        $course = $stmt->fetch();

        if (!$course) {
            throw new NotFoundException("Course with ID {$id} not found.");
        }

        return $course;
    }

    public function create(string $name, string $code): bool
    {
        if (empty($name) || empty($code)) {
            throw new ValidationException('Course name and code are required.');
        }

        try {
            $query = 'INSERT INTO courses (name, code) VALUES (:name, :code)';
            $stmt = $this->connection->prepare($query);

            return $stmt->execute([
                'name' => $name,
                'code' => $code,
            ]);

        } catch (PDOException $e) {
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode === 1062) {
                throw new ValidationException('Course code already exists.');
            }
            throw $e;
        }
    }

    public function update(int $id, string $name, string $code): bool
    {
        if ($id <= 0 || empty($name) || empty($code)) {
            throw new ValidationException('Invalid course data provided.');
        }

        $this->getById($id);

        try {
            $query = 'UPDATE courses SET name = :name, code = :code WHERE id = :id';
            $stmt = $this->connection->prepare($query);

            return $stmt->execute([
                'id' => $id,
                'name' => $name,
                'code' => $code,
            ]);

        } catch (PDOException $e) {
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode === 1062) {
                throw new ValidationException('Course code already exists.');
            }
            throw $e;
        }
    }

    public function delete(int $id): bool
    {
        $this->getById($id);

        $query = 'DELETE FROM courses WHERE id = :id';
        $stmt = $this->connection->prepare($query);

        return $stmt->execute(['id' => $id]);
    }
}
