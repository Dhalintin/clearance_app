<?php
session_start();

unset($_SESSION['clearanceOfficer']);

header("Location: login.php");
exit();
