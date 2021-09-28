<?php

namespace App\Actions;

use App\Database;
use App\Models\ClearancePin;

class ClearancePinActions
{
    private Database $db;
    protected $errors = [];
    protected $table = "clearance_pins";

    public function __construct() {
        $this->db = new Database();
    }

    public function validate(string $pinNo) {
        $query = "SELECT * FROM {$this->table} WHERE pin_no = :pin_no AND used_at IS NULL";
        $statement = $this->db->connection()->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_CLASS, ClearancePin::class);
        $statement->execute(['pin_no' => $pinNo]);
        return $statement->fetch();
    }

    public function setAsUsed(string $pinNo) {
        $query = "UPDATE {$this->table} SET used_at = NOW() WHERE pin_no = :pin_no";
        $statement = $this->db->connection()->prepare($query);
        $statement->execute(['pin_no' => $pinNo]);
        return true;
    }

    public function getErrors() {
        return $this->errors;
    }
}