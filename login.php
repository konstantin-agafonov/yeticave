<?php

require_once 'config.php';
require_once 'functions.php';
require_once 'userdata.php';

$form_validated = true;
$user_validated = null;

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
        $user_validated = false;
        foreach ($users as $user) {
            if ($user['email'] == $fields['email']['value'] && password_verify($fields['password']['value'],$user['password'])) {
                $user_validated = true;
                $_SESSION['auth']['user_email'] = $user['email'];
                $_SESSION['auth']['user_name'] = $user['name'];
                header("Location: /");
                exit();
            }
        }
        $form_validated = false;
    }

}



echo includeTemplate('templates/header.php');?>

<?=includeTemplate('templates/login.php',[
    'fields' => $fields,
    'form_validated' => $form_validated,
    'user_validated' => $user_validated
]);?>

<?=includeTemplate('templates/footer.php');?>
