<?php

use App\Actions\ClearanceOfficerActions;
use App\Actions\StudentActions;

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = (array_key_exists($key, $_ENV)) ? $_ENV[$key] : null;

        if ($value === null) {
            return $default;
        }

        return $value;
    }
}

if (!function_exists('checkStudentLogin')) {
    function checkStudentLogin()
    {
        if (isset($_SESSION['student'])) {
            return true;
        }
        return false;
    }
}

if (!function_exists('checkBursaryLogin')) {
    function checkBursaryLogin()
    {
        if (isset($_SESSION['clearanceOfficer']) && authClearanceOfficer()->office === 'bursary') {
            return true;
        }
        return false;
    }
}

if (!function_exists('authClearanceOfficer')) {
    function authClearanceOfficer()
    {
        return (new ClearanceOfficerActions())->findByUsername($_SESSION['clearanceOfficer']);
    }
}

if (!function_exists('authStudent')) {
    function authStudent()
    {
        return (new StudentActions)->findByRegNo($_SESSION['student']);
    }
}
