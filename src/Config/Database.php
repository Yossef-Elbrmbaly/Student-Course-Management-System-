<?php

namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private ?PDO $connection = null;

    public function __construct(private DatabaseConfig $config)
    {
    }

    public function connect(): PDO
    {
        if ($this->connection === null) {
            try {
                $this->connection = new PDO(
                    sprintf(
                        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                        $this->config->host(),
                        $this->config->port(),
                        $this->config->database()
                    ),
                    $this->config->username(),
                    $this->config->password()
                );

                $this->connection->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );

                $this->connection->setAttribute(
                    PDO::ATTR_DEFAULT_FETCH_MODE,
                    PDO::FETCH_ASSOC
                );

            } catch (PDOException $e) {
                throw $e;
            }
        }

        return $this->connection ;
    }
}
