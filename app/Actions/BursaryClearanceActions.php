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

    public function logStudent(array $input)
    {
        $query = "INSERT INTO {$this->table} (session, reg_no, clearance_status) VALUES (:session, :reg_no, :clearance_status)";
        $statement = $this->db->connection()->prepare($query);
        $statement->execute([
            ':reg_no' => $input['reg_no'],
            ':session' => $input['session'],
            ':clearance_status' => 'pending'
        ]);
        return true;
    }

    public function setStatus($regNo, $status)
    {
        $query = "UPDATE {$this->table} SET clearance_status = :status WHERE reg_no = :reg_no";
        $statement = $this->db->connection()->prepare($query);
        $statement->execute([':reg_no' => $regNo, ':status' => $status]);
        return true;
    }

    public function getStudentsBySession($session)
    {
        $query = "SELECT * FROM {$this->table} WHERE session = :session";
        $statement = $this->db->connection()->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_CLASS, BursaryClearance::class);
        $statement->execute([':session' => $session]);
        return $statement->fetchAll();
    }

    public function getAllSessions()
    {
        $query = "SELECT DISTINCT session FROM {$this->table} ORDER BY session";
        $statement = $this->db->connection()->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findExistingRecords(array $values, array $input)
    {
        $valuesStatement = "(" . implode(", ", array_map(function ($key, $item) {
            return ":regNo{$key}";
        }, array_keys($input), array_values($input))) . ")";
        $query = "SELECT * FROM {$this->table} WHERE reg_no IN " . $valuesStatement;
        $statement = $this->db->connection()->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_CLASS, BursaryClearance::class);
        $statement->execute($values);
        return $statement->fetchAll();
    }

    public function findStudent($regNo)
    {
        $query = "SELECT * FROM {$this->table} WHERE reg_no = :reg_no";
        $statement = $this->db->connection()->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_CLASS, BursaryClearance::class);
        $statement->execute(['reg_no' => $regNo]);
        return $statement->fetch();
    }

    public function addBatchRecord(array $input)
    {
        if (empty($input['session']) || empty($input['regNos'])) {
            array_push($this->errors, "Enter at least one student record");
            return;
        }
        $values = [];
        foreach ($input['regNos'] as $key =>  $regNo) {
            if (in_array($regNo, $values)) {
                unset($input['regNos'][$key]);
                continue;
            }
            $values['regNo' . $key] = $regNo;
        }
        $existingRecords = $this->findExistingRecords($values, $input['regNos']);
        if (count($existingRecords) !== 0) {
            $this->errors['duplicates'] = $existingRecords;
            return;
        }
        $query = "INSERT INTO {$this->table} (session, reg_no) VALUES ";
        $valuesStatement = implode(", ", array_map(function ($key, $item) {
            return "(:session, :regNo{$key})";
        }, array_keys($input['regNos']), array_values($input['regNos'])));
        $query .= $valuesStatement;
        $statement = $this->db->connection()->prepare($query);
        $values[':session'] = $input['session'];
        $statement->execute($values);
        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
