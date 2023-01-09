<?php

namespace Yeticave\App\Controllers;

use Yeticave\Core\ActiveRecord\Finder\UserFinder;
use Yeticave\Core\Controller;
use Yeticave\Core\User;
use Yeticave\Core\ActiveRecord\Record\UserRecord;
use Yeticave\App\Models\Categories;
use Yeticave\App\Models\Stakes;
use Respect\Validation\Validator as v;

class Users extends Controller
{
    public function loginAction()
    {
        $categories = Categories::selectAll();
        $user = new User('Db', false);

        if ($user->isLoggedIn()) {
            return $this->render('home/message.php', [
                'categories' => $categories,
                'user' => $user,
                'message' =>
                    '<p>Вы работаете от имени пользователя '
                    . $user->getUserName()
                    .'! Если это не вы, то зайдите под другим именем: <a href="/users/logout">Выход</a></p>'
            ]);
        }

        $form_validated = true;
        $user_validated = true;

        $fields = [
            "email" => [
                'v' => v::email()->notEmpty()->setName('email'),
                'value' => null,
                'errors' => []
            ],
            "password" => [
                'v' => v::stringType()->length(5,30)->notEmpty()->setName('password'),
                'value' => null,
                'errors' => []
            ],
        ];

        if (!empty($_POST)) {
            $this->validateFormFields($fields,$form_validated);
            if ($form_validated) {
                $user = new User(
                    'Db',
                    false,
                    $fields['email']['value'],
                    $fields['password']['value']
                );
            }
            $user_validated = false;
        }

        return $this->render('users/login.php', [
            'fields' => $fields,
            'form_validated' => $form_validated,
            'user_validated' => $user_validated,
            'categories' => $categories,
            'user' => $user
        ]);
    }

    public function logoutAction()
    {
        $user = new User('Db', false);
        if ($user->isLoggedIn()) {
            $user->logout();
        }
    }

    public function mylotsAction()
    {
        $categories = Categories::selectAll();
        $user = new User('Db', false);

        if (!$user->isLoggedIn()) {
            header("HTTP/1.1 403 Forbidden");
            return $this->render('home/message.php', [
                'categories' => $categories,
                'user' => $user,
                'message' =>
                    '<p>Страница доступна только для зарегистрированных пользователей! <a href="/">На главную</a></p>'
            ]);
        }

        $stakes = Stakes::selectByUserId($user->getUserId());

        return $this->render('users/mylots.php', [
            'stakes' => $stakes,
            'categories' => $categories,
            'user' => $user
        ]);
    }

    public function signupAction()
    {
        $categories = Categories::selectAll();
        $user = new User('Db', false);

        if ($user->isLoggedIn()) {
            return $this->render('home/message.php', [
                'categories' => Categories::selectAll(),
                'user' => $user,
                'message' =>
                    '<p>Страница только для незарегистрированных пользователей! <a href="/users/logout">Выйти</a></p>'
            ]);
        }

        $form_validated = true;
        $fields = [
            "name" =>   [
                'v' => v::stringType()->length(5,100)->notEmpty()->setName('name'),
                'value' => null,
                'errors' => []
            ],
            "email" => [
                'v' => v::email()->notEmpty()->setName('email'),
                'value' => null,
                'errors' => []
            ],
            "password" => [
                'v' => v::stringType()->length(5,30)->notEmpty()->setName('password'),
                'value' => null,
                'errors' => []
            ],
            "contacts" =>    [
                'v' => v::stringType()->length(5,1000)->notEmpty()->setName('contacts'),
                'value' => null,
                'errors' => []
            ],
        ];
        $file = [
            'error' => null,
            'name' => null,
            'path' => null
        ];

        if (!empty($_POST)) {
            $this->validateFormFields($fields, $form_validated);
            $this->validatePhotoUpload($file, $form_validated, false);
        }

        if (!empty($_POST) && $form_validated){
            $existing_user = UserFinder::findByEmail($fields['email']['value']);

            if ($existing_user) {
                $fields['email']['errors'][] = 'Пользователь с таким email уже существует!';
                $form_validated = false;
            } else {
                $new_pass_hash =  password_hash($fields['password']['value'], PASSWORD_DEFAULT);

                $new_user = new UserRecord('Yeticave\Core\Db',[
                    'email'     => $fields['email']['value'],
                    'name'      => $fields['name']['value'],
                    'contacts'  => $fields['contacts']['value'],
                    'password'  => $new_pass_hash,
                    'avatar'    => $file['name']
                ], true);

                $new_user_id = $new_user->save();

                if ($new_user_id) {
                    (
                        new User('Yeticave\Core\Db',
                        true,
                        $fields['email']['value'],
                        $fields['password']['value'])
                    );
                }
            }
        }

        return $this->render('users/signup.php', [
            'categories' => $categories,
            'user' => $user,
            'fields' => $fields,
            'form_validated' => $form_validated,
            'file' => $file
        ]);
    }
}
