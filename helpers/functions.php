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

if (!function_exists('public_path')) {
    function public_path($path = '/hello')
    {
        $path = trim($path, DIRECTORY_SEPARATOR);
        return (dirname(__DIR__, 1)  . DIRECTORY_SEPARATOR . 'public/' . (($path !== '') ? $path : ''));
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

if (!function_exists('checkClearanceOfficerLogin')) {
    function checkClearanceOfficerLogin($office = null)
    {
        if (isset($_SESSION['clearanceOfficer'])) {
            return (($office) ? (authClearanceOfficer()->office === $office) : true);
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
