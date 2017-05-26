<?php

/*spl_autoload_register(function ($class){
    $root = dirname(__DIR__);
    $file = $root . '/' . str_replace('\\','/',$class) . '.php';
    if (is_readable($file)) {
        require $file;
    }
});*/

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







