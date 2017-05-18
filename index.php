<?php

require_once 'config.php';
require_once 'functions.php';

// записать в эту переменную оставшееся время в этом формате (ЧЧ:ММ)
$lot_time_remaining = "00:00";

// временная метка для полночи следующего дня
$tomorrow = strtotime('tomorrow midnight');

// временная метка для настоящего времени
$now = time();

// далее нужно вычислить оставшееся время до начала следующих суток и записать его в переменную $lot_time_remaining
$lot_time_remaining = date("H:i", $tomorrow + ($tomorrow - $now));

$categories = db_select($db_conn,'select id,name from categories;');
$lots = db_select($db_conn,'select * from lots;');

echo includeTemplate('templates/header.php');

echo includeTemplate('templates/main.php',[
    'lots' => $lots,
    'categories' => $categories,
    'lot_time_remaining' => $lot_time_remaining
]);

echo includeTemplate('templates/footer.php',[
    'categories' => $categories
]);



