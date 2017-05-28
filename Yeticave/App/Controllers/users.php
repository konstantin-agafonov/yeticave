<?php

namespace Yeticave\App\Controllers;

use Yeticave\Core\View;
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

        $form_validated = true;

        if (!empty($_POST)) {

            $fields = [
                "email" => ['v' => v::email()->notEmpty()->setName('email') ],
                "password" => ['v' => v::stringType()->length(5,30)->notEmpty()->setName('password') ],
            ];

            $this->validateFormFields($fields,$form_validated);

            if ($form_validated) {
                $user = new User('Db',$fields['email']['value'],$fields['password']['value']);
            }

        }

        View::render('users/login.php',[
            'fields' => isset($fields) ? $fields : null,
            'form_validated' => $form_validated,
            'categories' => $categories,
            'user' => isset($user) ? $user : null
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

        $categories = Categories::selectAll();

        $user = new User('Db');

        if (!$user->isLoggedIn()) {
            header("HTTP/1.1 403 Forbidden");
            View::render('home/error.php',[
                'categories' => $categories,
                'user' => $user,
                'message' => '<p>Страница доступна только для зарегистрированных пользователей! <a href="/">На главную</a></p>'
            ]);
            die();
        }

        $stakes = Stakes::selectByUserId($user->getUserId());

        View::render('users/mylots.php',[
            'stakes' => $stakes,
            'categories' => $categories,
            'user' => $user
        ]);

    }

    public function signupAction()
    {
        $categories = Categories::selectAll();

        $user = new User('Db');

        $form_validated = true;

        if (!empty($_POST)) {

            $fields = [
                "name" =>   ['v' => v::stringType()->length(5,100)->notEmpty()->setName('name') ],
                "email" => ['v' => v::email()->notEmpty()->setName('email') ],
                "password" => ['v' => v::stringType()->length(5,30)->notEmpty()->setName('password') ],
                "contacts" =>    ['v' => v::stringType()->length(5,1000)->notEmpty()->setName('contacts') ],
            ];

            $this->validateFormFields($fields,$form_validated);

            $file = [];

            $this->validatePhotoUpload($file,$form_validated);

        }

        if (!empty($_POST) && $form_validated){

            $new_pass_hash =  password_hash($fields['password']['value'], PASSWORD_DEFAULT);

            $new_user = new UserRecord('Yeticave\Core\Db',[
                'email'     => $fields['email']['value'],
                'name'      => $fields['name']['value'],
                'contacts'  => $fields['contacts']['value'],
                'password'  => $new_pass_hash,
                'avatar'    => $file['name']
            ],true);

            $new_user_id = $new_user->save();

            if ($new_user_id) {

                $user = new User('Yeticave\Core\Db',$fields['email']['value'],$fields['password']['value']);

            }

        } else {

            View::render('users/signup.php', [
                'categories' => $categories,
                'user' => $user,
                'fields' => isset($fields) ? $fields : null,
                'form_validated' => $form_validated,
                'file' => isset($file) ? $file : null
            ]);

        }

    }

}