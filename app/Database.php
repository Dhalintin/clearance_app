<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    private $pdo;

    public function __construct()
    {
        $driver = 'mysql';
        $host = 'localhost';
        $dbname = 'clearance_app';
        $username = 'root';
        $password = '';
        $dsn = "{$driver}:dbname={$dbname};host={$host}";
        try {
            $pdo = new PDO($dsn, $username, '');
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
