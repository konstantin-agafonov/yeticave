<?php

use Yeticave\Core\View;

function includeTemplate(string $path2template = null, array $data = []) : string
{
    return View::render($path2template, $data);
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

function dd($var)
{
    echo '<pre>';
    var_dump($var); die();
}

function getCatById(array $array,int $id) {
    foreach ($array as $elem) {
        if ($elem['id']==$id) {
            return $elem['name'];
        }
    }
    return null;
}

function lotTimeRemaining(){
    // временная метка для полночи следующего дня
    $tomorrow = strtotime('tomorrow midnight');

    // временная метка для настоящего времени
    $now = time();

    // далее нужно вычислить оставшееся время до начала следующих суток и записать его в переменную $lot_time_remaining
    $lot_time_remaining = date("H:i", $tomorrow + ($tomorrow - $now));

    return $lot_time_remaining;
}






