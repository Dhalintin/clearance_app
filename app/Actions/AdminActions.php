<?php

namespace App\Actions;

use App\Database;
use App\Models\Admin;

class AdminActions
{
    private Database $db;
    protected $errors = [];
    protected $table = 'admin';

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function findByUsername($username)
    {
        $query = "SELECT * FROM {$this->table} WHERE username = :username";
        $statement = $this->db->connection()->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_CLASS, Admin::class);
        $statement->execute(['username' => $username]);
        return $statement->fetch();
    }

    public function login(array $input)
    {
        if (empty($input['username']) || empty($input['password'])) {
            array_push($this->errors, "All fields are required");
            return;
        }

        $admin = $this->findByUsername($input['username']);

        if ($admin) {
            if (!password_verify($input['password'], $admin->password)) {
                array_push($this->errors, "Incorect details");
            } else {
                $_SESSION['adminOfficer'] = $input['username'];
                return $admin;
            }
        } else {
            array_push($this->errors, "Your records were not found");
        }
        return;
    }
}
