<?php

namespace models;

use PDO;

class Course {
    public function __construct(private PDO $connection) {}

    public function getAll(): array {
        $query = "SELECT * FROM courses ORDER BY id ";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array {
        $query = "SELECT * FROM courses WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->execute(['id' => $id]);
        $course = $stmt->fetch();
        return $course ? $course : null;
    }

    public function create(string $name, string $code): bool {
        $query = "INSERT INTO courses (name, code) VALUES (:name, :code)";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute([
            'name' => $name,
            'code' => $code
        ]);
    }

    public function update(int $id, string $name, string $code): bool {
        $query = "UPDATE courses SET name = :name, code = :code WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute([
            'id'   => $id,
            'name' => $name,
            'code' => $code
        ]);
    }

    public function delete(int $id): bool {
        $query = "DELETE FROM courses WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}