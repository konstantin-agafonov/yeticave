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

$form_validated = true;

$fields = [
    "lot_id" => [
        'value' => null,
        'filter' => FILTER_VALIDATE_INT,
        'filter_options' => null,
        'validated' => true,
        'error' => null
    ],
    "cost" => [
        'value' => null,
        'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
        'filter_options' => [
            'flags' => FILTER_FLAG_ALLOW_FRACTION
        ],
        'validated' => true,
        'error' => null
    ],
];

if ($_POST) {

    foreach ($fields as $field_name => &$field) {
        $field['value'] = trim($_POST[$field_name]);
        $field['value'] = filter_var(
            $field['value'],
            $field['filter'] ? $field['filter'] : FILTER_DEFAULT,
            $field['filter_options']
        );
        if ($field['value'] === false || (string)$field['value'] == '') {
            $field['error'] = 'Введено некорректное значение';
            $field['validated'] = false;
        }
    }
    unset($field);

    if ($form_validated) {
        foreach ($fields as &$field) {
            if (!$field['validated']) {
                $form_validated = false;
                break;
            }
        }
        unset($field);
    }

}

if (isset($_COOKIE['stakes'])) {
    $stakes = json_decode($_COOKIE['stakes'],true);
} else {
    $stakes = [];
}

$have_stake = false;
foreach ($stakes as $stake) {
    if ($stake['id'] == $lot_id) {
        $have_stake = true;
        break;
    }
}

if ($_POST && $form_validated) {

    $stakes[] = [
        'id' => $fields['lot_id']['value'],
        'time' => time(),
        'cost' => $fields['cost']['value']
    ];
    setcookie('stakes', json_encode($stakes));

    header("Location: mylots.php");
    exit();

} else {

    echo includeTemplate('templates/header.php');
    echo includeTemplate('templates/lots.php', [
        'bets' => $bets,
        'lot' => $lots[$lot_id],
        'category' => $categories[$lots[$lot_id]['category']],
        'id' => $lot_id,
        'fields' => $fields,
        'have_stake' => $have_stake
    ]);
    echo includeTemplate('templates/footer.php');

}

