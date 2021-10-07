<?php
session_start();

unset($_SESSION['bursaryOfficer']);

header("Location: login.php");
exit();
