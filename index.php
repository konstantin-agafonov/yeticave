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

?>

<?php require_once 'data.php'; ?>

<?php require_once 'functions.php'; ?>

<?=includeTemplate('templates/header.php');?>

<?=includeTemplate('templates/main.php',[
    'lots' => $lots,
    'categories' => $categories,
    'lot_time_remaining' => $lot_time_remaining
]);?>

<?=includeTemplate('templates/footer.php');?>



