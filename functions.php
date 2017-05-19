<?php

spl_autoload_register(function ($class_name) {
    include "classes/" . $class_name . '.php';
});

/*function getSubarrayValueByAnotherValue(array $array,$searched_key,$searched_value,$key2get) {
    foreach ($array as $sub_array) {
        if (isset($sub_array[$searched_key]) && isset($sub_array[$key2get])) {
            if ($sub_array[$searched_key] === $searched_value) {
                return $sub_array[$key2get];
            }
        }
    }
    return null;
}*/

/*function getSubarrayByElementValue(array $array,$searched_key,$searched_value) {
    foreach ($array as $sub_array) {
        if (isset($sub_array[$searched_key])) {
            if ($sub_array[$searched_key] === $searched_value) {
                return $sub_array;
            }
        }
    }
    return null;
}*/

function includeTemplate(string $path2template = null, array $data = null) : string
{
    if (!file_exists($path2template)) {
        return '';
    }
    ob_start();
    include $path2template;
    $template = ob_get_clean();
    return $template;
}

function relativeTime(int $time): string
{
    $now = time();
    $diff = $now - $time;

    if ((($diff) / (60 * 60)) >= 24) {
        return date('d.m.y в H:i', $time);
    }

    if (($diff / 60) <= 60) {
        return round($diff / 60) . " минут назад";
    }

    return round($diff / (60 * 60)) . " часов назад";
}







