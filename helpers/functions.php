<?php

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
