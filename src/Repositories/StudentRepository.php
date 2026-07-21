<?php

namespace App\Repositories;

use App\Contracts\StudentRepositoryInterface;
use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use PDO;
use PDOException;

class StudentRepository implements StudentRepositoryInterface
{
    public function __construct(private PDO $connection)
    {
    }

    public function getAll(): array
    {
        $query = 'SELECT students.*, departments.name as department_name FROM students 
                LEFT JOIN departments ON students.department_id = departments.id
                ORDER BY students.id';

        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        if ($id <= 0) {
            throw new ValidationException('Invalid student ID provided.');
        }

        $query = 'SELECT * FROM students WHERE id = :id';

        $stmt = $this->connection->prepare($query);
        $stmt->execute(['id' => $id]);

        $student = $stmt->fetch();

        if (!$student) {
            throw new NotFoundException("Student with ID {$id} not found.");
        }

        return $student;
    }

    public function create(
        string $name,
        string $email,
        string $phone,
        int $department_id
    ): bool {
        if (empty($name) || empty($email)) {
            throw new ValidationException('Name and Email are required.');
        }

        try {
            $query = 'INSERT INTO students (name, email, phone, department_id) 
                    VALUES (:name, :email, :phone, :department_id)';

            $stmt = $this->connection->prepare($query);

            return $stmt->execute([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'department_id' => $department_id ?: null,
            ]);

        } catch (PDOException $e) {
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode === 1062) {
                throw new ValidationException('Email already exists.');
            }

            if ($errorCode === 1452) {
                throw new ValidationException('The selected department does not exist.');
            }

            throw $e;
        }
    }

    public function update(
        int $id,
        string $name,
        string $email,
        string $phone,
        int $department_id
    ): bool {
        if ($id <= 0 || empty($name) || empty($email)) {
            throw new ValidationException('Invalid data provided. ID, Name, and Email are required.');
        }

        $this->getById($id);

        try {
            $query = 'UPDATE students 
                    SET name = :name, email = :email, phone = :phone, department_id = :department_id 
                    WHERE id = :id';

            $stmt = $this->connection->prepare($query);

            return $stmt->execute([
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'department_id' => $department_id ?: null,
            ]);

        } catch (PDOException $e) {
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode === 1062) {
                throw new ValidationException('Email already exists.');
            }

            if ($errorCode === 1452) {
                throw new ValidationException('The selected department does not exist.');
            }

            throw $e;
        }
    }

    public function delete(int $id): bool
    {
        $this->getById($id);

        $query = 'DELETE FROM students WHERE id = :id';

        $stmt = $this->connection->prepare($query);

        return $stmt->execute(['id' => $id]);
    }
}
