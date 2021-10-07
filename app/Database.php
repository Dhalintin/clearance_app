<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    private $pdo;

    public function __construct()
    {
        $driver = env('DB_CONNECTION');
        $host = env('DB_HOST');
        $dbname = env('DB_NAME');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $dsn = "{$driver}:dbname={$dbname};host={$host}";
        try {
            $pdo = new PDO(
                $dsn,
                $username,
                $password
            );
        } catch (PDOException $error) {
            exit('Database error: ' . $error->getMessage());
        }
        $this->pdo = $pdo;
    }

    public function __destruct()
    {
        $this->pdo = null;
    }

    public function connection(): PDO
    {
        return $this->pdo;
    }
}
