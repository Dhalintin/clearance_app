<?php

require_once "../../../vendor/autoload.php";

use App\Actions\HostelClearanceActions;

$action = new HostelClearanceActions();

$data = $_GET;

if (empty($data['regNo']) || empty($data['status'])) {
	header("Location: " . $_SERVER['HTTP_REFERER']);
	exit();
}


$action->setStatus($data['regNo'], $data['status']);

$_SESSION['success'] = 'Clearance status has been updated successfully.';
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
