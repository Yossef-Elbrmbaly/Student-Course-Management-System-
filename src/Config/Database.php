<?php

namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private string $host;
    private string $port;
    private string $db_name;
    private string $username;
    private string $password;

    public function __construct()
    {
        $this->host = getenv('DB_HOST');
        $this->port = getenv('DB_PORT');
        $this->db_name = getenv('DB_NAME');
        $this->username = getenv('DB_USERNAME');
        $this->password = getenv('DB_PASSWORD');
    }

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
                die('Database connection problem: ' . $e->getMessage());
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
