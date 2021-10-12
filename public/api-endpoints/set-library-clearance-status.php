<?php

require_once "../../vendor/autoload.php";

use App\Actions\LibraryClearanceActions;

$action = new LibraryClearanceActions();

$data = json_decode(file_get_contents('php://input'), true);

$action->setStatus($data['regNo'], $data['status']);
