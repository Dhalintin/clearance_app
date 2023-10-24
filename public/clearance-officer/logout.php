<?php
session_start();


require_once '../../vendor/autoload.php';


if (checkAdminLogin()) {
    header("Location: ../../../admin/dashboard.php");
    exit();
}

unset($_SESSION['clearanceOfficer']);

header("Location: ./login.php");
exit();
