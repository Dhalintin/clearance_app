<?php
session_start();

unset($_SESSION['student']);

header("Location: login.php");
exit();