<?php

require_once 'config.php';

use Core\User;

$user = new User('Db');

// записать в эту переменную оставшееся время в этом формате (ЧЧ:ММ)
$lot_time_remaining = "00:00";

// временная метка для полночи следующего дня
$tomorrow = strtotime('tomorrow midnight');

// временная метка для настоящего времени
$now = time();

// далее нужно вычислить оставшееся время до начала следующих суток и записать его в переменную $lot_time_remaining
$lot_time_remaining = date("H:i", $tomorrow + ($tomorrow - $now));

$lots = \Core\Db::select(
<<< EOD
select  lots.*,
        categories.name as category_name
from    lots
        left join categories on lots.category_id = categories.id;
EOD
    );

echo includeTemplate('templates/header.php',[
    'user' => $user
]);

echo includeTemplate('templates/main.php',[
    'lots' => $lots,
    'categories' => $categories,
    'lot_time_remaining' => $lot_time_remaining
]);

echo includeTemplate('templates/footer.php',[
    'categories' => $categories,
    'user' => $user
]);



