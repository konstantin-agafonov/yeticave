<?php
// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

// записать в эту переменную оставшееся время в этом формате (ЧЧ:ММ)
$lot_time_remaining = "00:00";

// временная метка для полночи следующего дня
$tomorrow = strtotime('tomorrow midnight');

// временная метка для настоящего времени
$now = time();

// далее нужно вычислить оставшееся время до начала следующих суток и записать его в переменную $lot_time_remaining
$lot_time_remaining = date("H:i", $tomorrow + ($tomorrow - $now));

$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];

$lots = [
    [
        'name' => '2014 Rossignol District Snowboard',
        'category' => 0,
        'price' => 10999,
        'pic' => '../img/lot-1.jpg',
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => 0,
        'price' => 159999,
        'pic' => '../img/lot-2.jpg',
    ],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => 1,
        'price' => 8000,
        'pic' => '../img/lot-3.jpg',
    ],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => 2,
        'price' => 10999,
        'pic' => '../img/lot-4.jpg',
    ],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => 3,
        'price' => 7500,
        'pic' => '../img/lot-5.jpg',
    ],
    [
        'name' => 'Маска Oakley Canopy',
        'category' => 5,
        'price' => 5400,
        'pic' => '../img/lot-6.jpg',
    ],
];
?>



<?php require_once 'functions.php'; ?>

<?=includeTemplate('templates/header.php');?>

<?=includeTemplate('templates/main.php',[
    'lots' => $lots,
    'categories' => $categories,
    'lot_time_remaining' => $lot_time_remaining
]);?>

<?=includeTemplate('templates/footer.php');?>



