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
    } else {
        return round($diff / (60 * 60)) . " часов назад";
    }
}

// ставки пользователей, которыми надо заполнить таблицу
$bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];
?>

<?php require_once 'functions.php'; ?>

<?=includeTemplate('templates/header.php');?>

<?=includeTemplate('templates/lots.php',[
    'bets' => $bets
]);?>

<?=includeTemplate('templates/footer.php');?>


