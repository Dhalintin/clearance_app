<?php

namespace App\Models;

class BursaryClearance
{
    public $id;
    public $reg_no;
    public $session;
    public $clearance_status;

    public function isCleared()
    {
        return $this->clearance_status === 'cleared';
    }
}
