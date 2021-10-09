<?php

require_once "../../vendor/autoload.php";

use App\Actions\BursaryClearanceActions;

$action = new BursaryClearanceActions();
$student = $action->findStudent($_SESSION['student']);

if ($student && $student->clearance_status === 'cleared') {
    die(json_encode(['cleared' => true]));
}

if (!$student) {
    $student = authStudent();
    $action->logStudent([
        'reg_no' => $student->reg_no,
        'session' => $student->session,
    ]);
}

die(json_encode(['cleared' => false]));
