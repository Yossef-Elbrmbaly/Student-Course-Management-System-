<?php
namespace models;
use PDO;

class Student {
    public function __construct(private PDO $connection) {}

    public function getAll(): array {
        $query = "SELECT students.*, departments.name as department_name 
                FROM students 
                LEFT JOIN departments ON students.department_id = departments.id
                ORDER BY students.id ";
                
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array {
        $query = "SELECT * FROM students WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->execute(['id' => $id]);
        $student = $stmt->fetch();
        return $student ? $student : null;
    }

    public function create(string $name, string $email, string $phone, int $department_id): bool {
        $query = "INSERT INTO students (name, email, phone, department_id) 
                VALUES (:name, :email, :phone, :department_id)";
                
        $stmt = $this->connection->prepare($query);
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'department_id' => $department_id
        ]);
    }

    public function update(int $id, string $name, string $email, string $phone, int $department_id): bool {
        $query = "UPDATE students 
                SET name = :name, email = :email, phone = :phone, department_id = :department_id 
                WHERE id = :id";
                
        $stmt = $this->connection->prepare($query);
        return $stmt->execute([
            'id'            => $id,
            'name'          => $name,
            'email'         => $email,
            'phone'         => $phone,
            'department_id' => $department_id
        ]);
    }

    public function delete(int $id): bool {
        $query = "DELETE FROM students WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}