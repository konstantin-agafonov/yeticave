<?php

require_once 'config.php';

require_once 'data.php';

require_once 'functions.php';

// ставки пользователей, которыми надо заполнить таблицу
$bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];


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

<?=includeTemplate('templates/header.php');?>

<?=includeTemplate('templates/lots.php',[
    'bets' => $bets,
    'lot' => $lots[$lot_id],
    'category' => $categories[$lots[$lot_id]['category']]
]);?>

<?=includeTemplate('templates/footer.php');?>


