<?php

namespace App\Actions;

use App\Database;
use App\Models\BursaryClearance;

class BursaryClearanceActions
{
    private Database $db;
    protected $errors = [];
    protected $table = 'bursary_clearance';

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getStudentsBySession($session)
    {
        $query = "SELECT * FROM {$this->table} WHERE session = :session";
        $statement = $this->db->connection()->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_CLASS, BursaryClearance::class);
        $statement->execute(['session' => $session]);
        return $statement->fetchAll();
    }

    public function getAllSessions()
    {
        $query = "SELECT DISTINCT session FROM {$this->table} ORDER BY session";
        $statement = $this->db->connection()->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function addBatchRecord(array $input)
    {
        if (empty($input['session']) || empty($input['regNos'])) {
            array_push($this->errors, "Enter at least one student record");
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
