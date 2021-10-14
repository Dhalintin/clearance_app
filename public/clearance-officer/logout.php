<?php
session_start();

if (checkAdminLogin()) {
    header("Location: ../../../admin/dashboard.php");
    exit();
}

unset($_SESSION['clearanceOfficer']);

header("Location: login.php");
exit();
