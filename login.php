<?php

require_once 'config.php';
require_once 'functions.php';

$form_validated = true;
$user_validated = true;

$fields = [
    "email" => [
        'value' => null,
        'filter' => FILTER_VALIDATE_EMAIL,
        'validated' => true,
        'error' => null
    ],
    "password" => [
        'value' => null,
        'filter' => FILTER_SANITIZE_STRING,
        'validated' => true,
        'error' => null
    ],
];

if ($_POST) {

    foreach ($fields as $field_name => &$field) {
        if (!isset($_POST[$field_name]) || $_POST[$field_name] == '') {
            $field['error'] = 'Поле должно быть заполнено';
            $field['validated'] = false;
            continue;
        } else {
            $field['value'] = trim($_POST[$field_name]);
        }
        $field['value'] = filter_var(
            $field['value'],
            $field['filter'] ? $field['filter'] : FILTER_DEFAULT
        );
        if ($field['value'] === false || $field['value'] == '') {
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

    if ($form_validated) {

        $user_from_db = db_select($db_conn,'select * from users where email= ?;',[$fields['email']['value']]);

        if ($user_from_db) {
            if (password_verify($fields['password']['value'],$user_from_db[0]['password'])) {
                $_SESSION['auth']['user_id'] = $user_from_db[0]['id'];
                $_SESSION['auth']['user_email'] = $user_from_db[0]['email'];
                $_SESSION['auth']['user_name'] = $user_from_db[0]['name'];
                $_SESSION['auth']['user_avatar'] = $user_from_db[0]['avatar'];
                header("Location: /");
                exit();
            } else {
                $form_validated = false;
                $user_validated = false;
            }
        } else {
            $form_validated = false;
            $user_validated = false;
        }
    }

}

$categories = db_select($db_conn,'select id,name from categories;');

echo includeTemplate('templates/header.php');?>

<?=includeTemplate('templates/login.php',[
    'fields' => $fields,
    'form_validated' => $form_validated,
    'user_validated' => $user_validated,
    'categories' => $categories
]);?>

<?=includeTemplate('templates/footer.php',[
    'categories' => $categories
]);?>
