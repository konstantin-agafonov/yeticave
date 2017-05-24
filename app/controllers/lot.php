<?php

namespace App\Controllers;

use Core\View;
use Core\User;
use Core\Db;
use Core\ActiveRecord\Finder\LotFinder;
use Core\ActiveRecord\Record\StakeRecord;
use Core\ActiveRecord\Record\LotRecord;


class Lot extends \Core\Controller
{

    public function showLotByIdAction()
    {

        $categories = \App\Models\Categories::selectAll();

        $user = new User('Db');

        $lot_id = $this->route_params['id'];

        $lot = LotFinder::findById($lot_id);

        if (!$lot) {
            header('HTTP/1.1 404 Not Found');
            View::render('home/error.php',[
                'categories' => $categories,
                'user' => $user,
                'message' => '<p>Запрошенного лота не существует! <a href="/">На главную</a></p>'
            ]);
            die();
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

            $new_stake = new StakeRecord('Core\Db',[
                'stake_sum' => $fields['cost']['value'],
                'user_id'   => $user->getUserId(),
                'lot_id'    => $fields['lot_id']['value']
            ],true);

            $new_stake_id = $new_stake->save();

        }

        if (isset($lot) && $lot !== false) {

            // ставки пользователей, которыми надо заполнить таблицу
            $stakes = \App\Models\Stakes::selectByLotId((isset($lot_id)) ? $lot_id : $fields['lot_id']['value']);

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

            View::render('lot/lot.php',[
                'stakes' => $stakes,
                'lot' => $lot,
                'fields' => $fields,
                'have_stake' => $have_stake,
                'categories' => $categories,
                'user' => $user
            ]);

        } else {

            View::render('lot/error.php',[
                'categories' => $categories,
                'user' => $user
            ]);


        }

    }

    public function addAction()
    {

        $categories = \App\Models\Categories::selectAll();

        $user = new User('Db');

        if (!$user->isLoggedIn()) {
            header("HTTP/1.1 403 Forbidden");
            View::render('home/error.php',[
                'categories' => $categories,
                'user' => $user,
                'message' => '<p>Страница доступна ТОЛЬКО для зарегистрированных пользователей! <a href="/">На главную</a></p>'
            ]);
            die();
        }

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
                    $file['path'] = $_SERVER["DOCUMENT_ROOT"] . '\public\uploads\\' . $file['name'];
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

        if ($_POST && $form_validated){

            $dtime = \DateTime::createFromFormat("d.m.Y", $fields['lot-date']['value']);
            $timestamp = $dtime->format("Y-m-d H:i:s");

            $new_lot = new LotRecord('Core\Db',[
                'pic'           => '../uploads/' . $file['name'],
                'name'          => $fields['lot-name']['value'],
                'description'   => $fields['message']['value'],
                'start_price'   => (float)$fields['lot-rate']['value'],
                'end_date'      => $timestamp,
                'stake_step'    => (float)$fields['lot-step']['value'],
                'author_id'     => $user->getUserId(),
                'category_id'   => $fields['category']['value']
            ],true);

            $new_lot_id = $new_lot->save();

            if ($new_lot_id) {

                header("Location: /lot/" . $new_lot_id);
                exit();

            } else {

                View::render('home/error.php',[
                    'categories' => $categories,
                    'user' => $user,
                    'message' => '<p>Ошибка при обработке формы! <a href="/">На главную</a></p>'
                ]);

            }

        } else {

            View::render('lot/add.php',[
                'categories' => $categories,
                'form_validated' => $form_validated,
                'fields' => $fields,
                'file' => isset($file) ? $file : null,
                'user' => $user,
                'message' => '<p>Ошибка при обработке формы! <a href="/">На главную</a></p>'
            ]);

        }

    }

}