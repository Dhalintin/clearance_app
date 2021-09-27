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
        $query = "SELECT * FROM {$this->table} WHERE pin_no = :pin_no AND used_at = NULL";
        $statement = $this->db->connection()->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_CLASS, ClearancePin::class);
        $statement->execute(['pin_no' => $pinNo]);
        return $statement->fetch();
    }

    public function getErrors() {
        return $this->errors;
    }
}