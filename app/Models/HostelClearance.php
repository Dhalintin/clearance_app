<?php

namespace App\Models;

class HostelClearance
{
    public $id;
    public $reg_no;
    public $accomodation_session;
    public $clearance_status;
    public $hostelRecords;

    public function isCleared()
    {
        return $this->clearance_status === 'cleared';
    }
}
