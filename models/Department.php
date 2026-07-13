<?php

namespace models;

use PDO;

class Department {
    public function __construct(private PDO $connection) {}

    public function getAll(): array {
        $query = "SELECT * FROM departments ORDER BY id ";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array {
        $query = "SELECT * FROM departments WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->execute(['id' => $id]);
        $department = $stmt->fetch();
        return $department ? $department : null;
    }

    public function create(string $name): bool {
        $query = "INSERT INTO departments (name) VALUES (:name)";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute(['name' => $name]);
    }

    public function update(int $id, string $name): bool {
        $query = "UPDATE departments SET name = :name WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute([
            'id'   => $id,
            'name' => $name
        ]);
    }

    public function delete(int $id): bool {
        $query = "DELETE FROM departments WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}