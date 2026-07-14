<?php

namespace config;

use PDO;
use PDOException;

class Database
{
    private string $host = "db.fr-pari1.bengt.wasmernet.com";
    private string $port = "10272";
    private string $db_name = "DB_NAME";
    private string $username = "user_8dcb59ce";
    private string $password = "pw_3kllsUENAPJIOTyYvG1MDoYAnqlESWSI";

    public ?PDO $conn = null;

    public function connect(): ?PDO
    {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO(
                    "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8mb4",
                    $this->username,
                    $this->password
                );

                $this->conn->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );

                $this->conn->setAttribute(
                    PDO::ATTR_DEFAULT_FETCH_MODE,
                    PDO::FETCH_ASSOC
                );

            } catch (PDOException $e) {
                die("Database connection problem: " . $e->getMessage());
            }
        }

        return $this->conn;
    }

    public function checkConnection(): bool
    {
        try {
            $this->connect();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}