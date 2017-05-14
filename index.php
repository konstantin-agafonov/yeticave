<?php

require_once 'config.php';

// записать в эту переменную оставшееся время в этом формате (ЧЧ:ММ)
$lot_time_remaining = "00:00";

// временная метка для полночи следующего дня
$tomorrow = strtotime('tomorrow midnight');

// временная метка для настоящего времени
$now = time();

// далее нужно вычислить оставшееся время до начала следующих суток и записать его в переменную $lot_time_remaining
$lot_time_remaining = date("H:i", $tomorrow + ($tomorrow - $now));

require_once 'data.php';

require_once 'functions.php';

echo includeTemplate('templates/header.php');

db_update(
    $db_conn,
    'users',
    ['name'=>'value1','email'=>300],
    ['id'=>33,'password'=>400]
);

?>



<?=includeTemplate('templates/main.php',[
    'lots' => $lots,
    'categories' => $categories,
    'lot_time_remaining' => $lot_time_remaining
]);?>

<?=includeTemplate('templates/footer.php');?>



