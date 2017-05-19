<?php

require_once 'config.php';

if (isset($_GET['id']) && ($_GET['id'] != '')) {

    $lot_id = (int)$_GET['id'];
    $lot = $db->select(
<<< EOD
select  lots.*,
        categories.name as category_name
from    lots
        left join categories on lots.category_id = categories.id
where   lots.id= ?;
EOD
,[$lot_id]
    );

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

    $lot = $db->select(
<<< EOD
select  lots.*,
        categories.name as category_name
from    lots
        left join categories on lots.category_id = categories.id
where   lots.id = ?;
EOD
        ,[$fields['lot_id']['value']]
    );

    $new_stake_id = $db->insert('insert into stakes (stake_sum,user_id,lot_id) values (?,?,?);',[
        $fields['cost']['value'],
        $_SESSION['auth']['user_id'],
        $fields['lot_id']['value']
    ]);

}

if (isset($lot) && $lot !== false) {

    // ставки пользователей, которыми надо заполнить таблицу
    $stakes = $db->select(
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
            if ($stake['user_id'] == $_SESSION['auth']['user_id']) {
                $have_stake = true;
                break;
            }
        }
    } else {
        $stakes = [];
    }

    $lot = $lot[0];

    echo includeTemplate('templates/header.php');
    echo includeTemplate('templates/lots.php', [
        'stakes' => $stakes,
        'lot' => $lot,
        'fields' => $fields,
        'have_stake' => $have_stake,
        'categories' => $categories
    ]);

} else {

    echo includeTemplate('templates/header.php');
    echo "<main><p>Ошибка! <a href='/'>На главную</a></p></main>";

}

echo includeTemplate('templates/footer.php', [
    'categories' => $categories
]);



