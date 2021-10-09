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
        
        $query = "INSERT INTO {$this->table} (session, reg_no) VALUES ";
        
        $valuesStatement = implode(", ", array_map(function($key, $item) {
            return "(:session, :regNo{$key})";
        }, array_keys($input['regNos']), array_values($input['regNos'])));
    
        $query .= $valuesStatement;
        
        $statement = $this->db->connection()->prepare($query);
        
        $values = [
            ':session' => $input['session']
        ];
        
        foreach($input['regNos'] as $key =>  $regNo) {
            $values['regNo' . $key] = $regNo;
        }
        
        $statement->execute($values);
        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
