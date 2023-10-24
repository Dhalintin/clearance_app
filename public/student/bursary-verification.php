<?php


require_once "../../vendor/autoload.php";

use App\Actions\BursaryClearanceActions;

$action = new BursaryClearanceActions();
$student = $action->findStudent($_SESSION['student']);
 

if (!$student) {
    $student = authStudent();
    $action->logStudent([
        'reg_no' => $student->reg_no,
        'session' => $student->session,
    ]);
    $_SESSION['clearanceRequestCreated'] = 'Your clearance request has been sent to the faculty department and is awaiting approval.';
}


header("Location: dashboard.php");
exit();
