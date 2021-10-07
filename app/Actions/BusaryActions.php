<?php

namespace App\Actions;

use App\Database;
use App\Models\BursaryOfficer;

class BusaryActions
{
    private Database $db;
    protected $errors = [];
    protected $table = 'bursary_office';

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
        $statement->setFetchMode(\PDO::FETCH_CLASS, BursaryOfficer::class);
        $statement->execute(['username' => $username]);
        return $statement->fetch();
    }

    public function login(array $input)
    {
        if (empty($input['username']) || empty($input['password'])) {
            array_push($this->errors, "All fields are required");
            return;
        }

        $bursaryOfficer = $this->findByUsername($input['username']);

        if ($bursaryOfficer) {
            if (!password_verify($input['password'], $bursaryOfficer->password)) {
                array_push($this->errors, "Incorect details");
            } else {
                $_SESSION['bursaryOfficer'] = $input['username'];
                return true;
            }
        } else {
            array_push($this->errors, "Your records were not found");
        }
        return;
    }
}
