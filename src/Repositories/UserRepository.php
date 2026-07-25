<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Exceptions\ValidationException;
use PDO;
use PDOException;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private PDO $connection)
    {
    }

    public function create(
        int $studentId,
        string $email,
        string $password,
        string $role
    ): bool {

        try {

            $query = 'INSERT INTO users (student_id, email, password, role)
                        VALUES (:student_id, :email, :password, :role)';

            $stmt = $this->connection->prepare($query);

            return $stmt->execute([
                'student_id' => $studentId,
                'email' => $email,
                'password' => $password,
                'role' => $role,
            ]);

        } catch (PDOException $e) {

            if (($e->errorInfo[1] ?? null) === 1062) {
                throw new ValidationException('User already exists.');
            }

            throw $e;
        }
    }

    public function getByEmail(string $email): ?array
    {
        $query = 'SELECT * FROM users WHERE email = :email';

        $stmt = $this->connection->prepare($query);

        $stmt->execute([
            'email' => $email,
        ]);

        return $stmt->fetch() ?: null;
    }
}
