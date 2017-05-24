<?php

namespace App\Controllers;

use Core\View;
use Core\User;
use Core\Db;
use Core\ActiveRecord\Record\UserRecord;
use Core\ActiveRecord\Finder\UserFinder;


class Users extends \Core\Controller
{

    public function loginAction()
    {

        $categories = Db::select('select id,name from categories;');

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

                $user = new User('Db',$fields['email']['value'],$fields['password']['value']);

                if (!$user->isLoggedIn()) {
                    $form_validated = false;
                }

            }

        }

        View::render('users/login.php',[
            'fields' => $fields,
            'form_validated' => $form_validated,
            'categories' => $categories,
            'user' => isset($user) ? $user : /*new User('Db')*/null
        ]);

    }

    public function logoutAction()
    {
        $user = new User('Db');

        if ($user->isLoggedIn()) {
            $user->logout();
        }
    }

    public function mylotsAction()
    {

        $categories = Db::select('select id,name from categories;');

        $user = new User('Db');

        if (!$user->isLoggedIn()) {
            header("HTTP/1.1 403 Forbidden");
            die("Страница доступна только для зарегистрированных пользователей!");
        }

        $stakes = Db::select(
<<< EOD
select  stakes.*,
        lots.pic as lot_pic,
        lots.name as lot_name,
        categories.name as category_name
from stakes
left join lots on stakes.lot_id = lots.id
left join categories on lots.category_id = categories.id
where user_id = ?;
EOD
            ,[$user->getUserId()]
        );

        View::render('users/mylots.php',[
            'stakes' => $stakes,
            'categories' => $categories,
            'user' => $user
        ]);

    }

    public function signupAction()
    {
        $categories = Db::select('select id,name from categories;');

        $user = new User('Db');

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

            $new_pass_hash =  password_hash($fields['password']['value'], PASSWORD_DEFAULT);

            $new_user = new /*\Core\ActiveRecord\Record\*/UserRecord('Core\Db',[
                'email'     => $fields['email']['value'],
                'name'      => $fields['name']['value'],
                'contacts'  => $fields['contacts']['value'],
                'password'  => $new_pass_hash,
                'avatar'    => $file['name']
            ],true);

            $new_user_id = $new_user->save();

            if ($new_user_id) {

                View::render('users/signup_success.php',[
                    'categories' => $categories,
                    'user' => $user
                ]);

            }

        } else {

            View::render('users/signup.php', [
                'categories' => $categories,
                'user' => $user,
                'fields' => $fields,
                'form_validated' => $form_validated,
                'file' => isset($file) ? $file : null
            ]);

        }

    }

}