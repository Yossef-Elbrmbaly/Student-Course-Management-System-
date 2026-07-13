<?php

namespace Config;

use PDO;
use PDOException;

class Database {
    private string $host = "db.fr-pari1.bengt.wasmernet.com";
    private string $port = "
10272";
    private string $db_name = "DB_NAME";
    private string $username = "user_99fbe122";
    private string $password = "pw_FeJluL9CUR95XiYE6ODwRAUfUJZIE4cS
";
    public ?PDO $conn = null;

    public function connect(): ?PDO {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO(
                    "mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                    $this->username, 
                    $this->password,
                    $this->port
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
