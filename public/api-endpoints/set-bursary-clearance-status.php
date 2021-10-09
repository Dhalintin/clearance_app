<?php

require_once "../../vendor/autoload.php";

use App\Actions\BursaryClearanceActions;

$action = new BursaryClearanceActions();

$data = json_decode(file_get_contents('php://input'), true);

$action->setStatus($data['regNo'], $data['status']);
