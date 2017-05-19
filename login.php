<?php

require_once 'config.php';

$form_validated = true;

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

        $user = new User($db,$fields['email']['value'],$fields['password']['value']);

        if (!$user->logged_in) {
            $form_validated = false;
        }

    }

}

echo includeTemplate('templates/header.php',[
    'user' => $user
]);?>

<?=includeTemplate('templates/login.php',[
    'fields' => $fields,
    'form_validated' => $form_validated,
    'user_validated' => isset($user) ? $user->logged_in : true,
    'categories' => $categories
]);?>

<?=includeTemplate('templates/footer.php',[
    'categories' => $categories,
    'user' => $user
]);?>
