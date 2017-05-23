<?php

require_once 'config.php';

use Core\Db;
use Core\User;
use ActiveRecord\Finder\LotFinder;

$user = new User('Db');

if (isset($_GET['id']) && ($_GET['id'] != '')) {

    $lot_id = (int)$_GET['id'];

    $lot = LotFinder::findById($lot_id);

    if (!$lot) {
        header('HTTP/1.1 404 Not Found');
        die('Запрошенного лота не существует!');
    }

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

if ($_POST && $form_validated) {

    $lot = LotFinder::findById($fields['lot_id']['value']);

    $new_stake = new \ActiveRecord\Record\StakeRecord('Core\Db',[
        'stake_sum' => $fields['cost']['value'],
        'user_id'   => $user->getUserId(),
        'lot_id'    => $fields['lot_id']['value']
    ],true);

    $new_stake_id = $new_stake->save();

}

if (isset($lot) && $lot !== false) {

    // ставки пользователей, которыми надо заполнить таблицу
    $stakes = Db::select(
<<< EOD
select  stakes.*,
        users.name as user_name
from    stakes
        left join users on stakes.user_id = users.id
where   lot_id = ?;
EOD
        ,[ (isset($lot_id)) ? $lot_id : $fields['lot_id']['value'] ]
    );

    $have_stake = false;

    if ($stakes) {
        foreach ($stakes as $stake) {
            if ($stake['user_id'] == $user->getUserId()) {
                $have_stake = true;
                break;
            }
        }
    } else {
        $stakes = [];
    }

    echo includeTemplate('templates/header.php',[
        'user' => $user
    ]);
    echo includeTemplate('templates/lots.php', [
        'stakes' => $stakes,
        'lot' => $lot,
        'fields' => $fields,
        'have_stake' => $have_stake,
        'categories' => $categories,
        'user' => $user
    ]);

} else {

    echo includeTemplate('templates/header.php',[
        'user' => $user
    ]);
    echo "<main><p>Ошибка! <a href='/'>На главную</a></p></main>";

}

echo includeTemplate('templates/footer.php', [
    'categories' => $categories,
    'user' => $user
]);



