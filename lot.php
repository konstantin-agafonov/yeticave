<?php

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


// ставки пользователей, которыми надо заполнить таблицу
$bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];

require_once 'data.php';

if (isset($_GET['id']) and ($_GET['id']!='')) {
    $lot_id = (int) $_GET['id'];
    if (!isset($lots[$lot_id])) {
        header('HTTP/1.1 404 Not Found');
        die('Запрошенного лота не существует!');
    }
} else {
    header('HTTP/1.1 404 Not Found');
    die('Запрошенного лота не существует!');
}

?>


<?php require_once 'functions.php'; ?>

<?=includeTemplate('templates/header.php');?>

<?=includeTemplate('templates/lots.php',[
    'bets' => $bets,
    'lot' => $lots[$lot_id],
    'category' => $categories[$lots[$lot_id]['category']]
]);?>

<?=includeTemplate('templates/footer.php');?>


