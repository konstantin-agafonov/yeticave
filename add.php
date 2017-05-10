<?php

require_once 'config.php';

if (!isset($_SESSION['auth']['user_email'])) {
    header("HTTP/1.1 403 Forbidden");
    die("Страница доступна только для зарегистрированных пользователей!");
}

require_once 'data.php';

require_once 'functions.php';

global $categories;

$form_validated = true;

$fields = [
    "lot-name" => [
        'value' => null,
        'filter' => FILTER_SANITIZE_STRING,
        'filter_options' => null,
        'validated' => true,
        'error' => null
    ],
    "category" => [
        'value' => null,
        'filter' => FILTER_VALIDATE_INT,
        'filter_options' => null,
        'validated' => true,
        'error' => null
    ],
    "message" => [
        'value' => null,
        'filter' => FILTER_SANITIZE_STRING,
        'filter_options' => null,
        'validated' => true,
        'error' => null
    ],
    "lot-rate" => [
        'value' => null,
        'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
        'filter_options' => [
            'flags' => FILTER_FLAG_ALLOW_FRACTION
        ],
        'validated' => true,
        'error' => null
    ],
    "lot-step" => [
        'value' => null,
        'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
        'filter_options' => [
            'flags' => FILTER_FLAG_ALLOW_FRACTION
        ],
        'validated' => true,
        'error' => null
    ],
    "lot-date" => [
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

    if ($fields['lot-rate']['validated']) {
        if ($fields['lot-rate']['value'] == 0.00 ) {
            $fields['lot-rate']['validated'] = false;
            $fields['lot-rate']['error'] = 'Поле должно быть заполнено';
        }
    }
    if ($fields['lot-step']['validated']) {
        if ($fields['lot-step']['value'] == 0.00 ) {
            $fields['lot-step']['validated'] = false;
            $fields['lot-step']['error'] = 'Поле должно быть заполнено';
        }
    }

    if ($fields['lot-date']['validated']) {
        $test_date = explode('.', $fields['lot-date']['value']);
        if (!checkdate($test_date[1], $test_date[0], $test_date[2])) {
            $fields['lot-date']['validated'] = false;
            $fields['lot-date']['error'] = 'Введено некорректное значение';
        }
    }

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
        foreach ($fields as &$field) {
            if (!$field['validated']) {
                $form_validated = false;
                break;
            }
        }
        unset($field);
    }

}


echo includeTemplate('templates/header.php');


if ($_POST && $form_validated){

    echo includeTemplate('templates/lots.php',[
        'bets' => [],
        'lot' => [
            'name' => $fields['lot-name']['value'],
            'category' => $fields['category']['value'],
            'price' => $fields['lot-rate']['value'],
            'pic' => '../uploads/' . $file['name'],
            'description' => $fields['message']['value'],
            'step' => $fields['lot-step']['value'],
        ],
        'category' => $categories[ $fields['category']['value'] ]
    ]);

} else {

    echo includeTemplate('templates/add-lot.php',[
        'categories' => $categories,
        'form_validated' => $form_validated,
        'fields' => $fields,
        'file' => isset($file) ? $file : null
    ]);

}


echo includeTemplate('templates/footer.php');
