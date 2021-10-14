<?php

namespace App\Actions;

use App\Database;
use App\Models\ClearanceOfficer;

class ClearanceOfficerActions
{
    private Database $db;
    protected $errors = [];
    protected $table = 'clearance_officers';

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
        $statement->setFetchMode(\PDO::FETCH_CLASS, ClearanceOfficer::class);
        $statement->execute(['username' => $username]);
        return $statement->fetch();
    }

    public function login(array $input)
    {
        if (empty($input['username']) || empty($input['password'])) {
            array_push($this->errors, "All fields are required");
            return;
        }

        $clearanceOfficer = $this->findByUsername($input['username']);

        if ($clearanceOfficer) {
            if (!password_verify($input['password'], $clearanceOfficer->password)) {
                array_push($this->errors, "Incorect details");
            } else {
                $_SESSION['clearanceOfficer'] = $input['username'];
                return $clearanceOfficer;
            }
        } else {
            array_push($this->errors, "Your records were not found");
        }
        return;
    }

    public function getAllOfficers()
    {
        $query = "SELECT * FROM {$this->table}";
        $statement = $this->db->connection()->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_CLASS, ClearanceOfficer::class);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function createClearanceOfficer(array $input)
    {
        if (empty($input['username']) || empty($input['password']) || empty($input['office']) || empty($input['fullname'])) {
            array_push($this->errors, "All fields are required!");
            return;
        }

        if ($this->findByUsername($input['username'])) {
            array_push($this->errors, "An officer with this username exists!");
            return;
        }

        if (strlen($input['password']) < 6) {
            array_push($this->errors, "Enter a longer password!");
            return;
        }

        $query = "INSERT INTO {$this->table} (username, password, office, fullname) VALUES (:username, :password, :office, :fullname)";
        $statement = $this->db->connection()->prepare($query);
        $statement->execute([
            ':office' => $input['office'],
            ':username' => $input['username'],
            ':password' => password_hash($input['password'], PASSWORD_DEFAULT),
            ':fullname' => $input['fullname']
        ]);
        return true;
    }
}
