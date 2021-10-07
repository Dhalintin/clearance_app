<?php

namespace App\Actions;

use App\Database;

class StudentClearanceActions
{
    public Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }
}
