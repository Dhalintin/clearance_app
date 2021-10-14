<?php
session_start();

unset($_SESSION['adminOfficer']);

header("Location: login.php");
exit();
