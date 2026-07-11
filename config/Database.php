<?php

namespace Config;

use PDO;
use PDOException;

class Database {
    private string $host = "localhost";
    private string $db_name = "student_management";
    private string $username = "root";
    private string $password = "";
    public ?PDO $conn = null;

    public function connect(): ?PDO {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO(
                    "mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                    $this->username, 
                    $this->password
                );
                
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                
            } catch(PDOException $e) {
                die("Database connection problem:" . $e->getMessage());
            }
        }
        return $this->conn;
    }
}