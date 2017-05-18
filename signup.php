<?php

require_once 'config.php';
require_once 'functions.php';

$form_validated = true;

$fields = [
    "name" => [
        'value' => null,
        'filter' => FILTER_SANITIZE_STRING,
        'filter_options' => null,
        'validated' => true,
        'error' => null
    ],
    "email" => [
        'value' => null,
        'filter' => FILTER_VALIDATE_EMAIL,
        'filter_options' => null,
        'validated' => true,
        'error' => null
    ],
    "password" => [
        'value' => null,
        'filter' => FILTER_SANITIZE_STRING,
        'filter_options' => null,
        'validated' => true,
        'error' => null
    ],
    "contacts" => [
        'value' => null,
        'filter' => FILTER_SANITIZE_STRING,
        'filter_options' => null,
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
            $field['filter'] ? $field['filter'] : FILTER_DEFAULT,
            $field['filter_options']
        );
        if ($field['value'] === false || (string)$field['value'] == '') {
            $field['error'] = 'Введено некорректное значение';
            $field['validated'] = false;
        }
    }
    unset($field);

    if (isset($_FILES['photo']) && !$_FILES['photo']['error']) {
        if (in_array($_FILES['photo']['type'],['image/jpeg','image/png'])) {
            $file['name'] = basename($_FILES['photo']['name']);
            $file['path'] = $_SERVER["DOCUMENT_ROOT"] . '\uploads\\' . $file['name'];
            if (!move_uploaded_file($_FILES['photo']['tmp_name'],$file['path'])) {
                $file['error'] = 'Ошибка при загрузке картинки';
                $form_validated = false;
            }
        } else {
            $file['error'] = 'Картинка должна быть в формате jpeg или png';
            $form_validated = false;
        }
    } else {
        $file['error'] = 'Картинка должна быть загружена';
        $form_validated = false;
    }

    if ($form_validated) {
        foreach ($fields as $field) {
            if (!$field['validated']) {
                $form_validated = false;
                break;
            }
        }
    }

}

$categories = db_select($db_conn,'select id,name from categories;');

echo includeTemplate('templates/header.php');

if ($_POST && $form_validated){

    $new_pass_hash =  password_hash($fields['password']['value'], PASSWORD_DEFAULT);

    $new_user_id = db_insert($db_conn,'insert into users (email,name,contacts,password,avatar) values (?,?,?,?,?);',[
        $fields['email']['value'],
        $fields['name']['value'],
        $fields['contacts']['value'],
        $new_pass_hash,
        $file['name']
    ]);

    if ($new_user_id) {
        echo "<main><p>Вы были успешно зарегистрированы! Зайдите на сайт на <a href='login.php'>странице входа</a>
            , используя свои email и пароль.</p></main>";
    }

} else {

    echo includeTemplate('templates/sign-up.php', [
        'categories' => $categories,
        'fields' => $fields,
        'form_validated' => $form_validated,
        'file' => isset($file) ? $file : null
    ]);

}

echo includeTemplate('templates/footer.php',[
    'categories' => $categories
]);
