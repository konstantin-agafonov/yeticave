<?php

namespace Core;

use ActiveRecord\Finder\UserFinder;
use ActiveRecord\Record\UserRecord;

class User {

    private $db;
    private $user_record;
    private $user_name;
    private $user_id;
    private $user_email;
    private $user_avatar;
    private $logged_in = false;

    function __construct(string $dbClassName,string $email = null,string $password = null) {

        $this->db = $dbClassName;

        if ($email && $password) {
            if ($authenticated_user = $this->authenticate($email,$password)) {
                $this->login($authenticated_user);
            }
        } else {
            $this->checkIfLoggedIn();
        }

    }

    private function authenticate(string $email,string $password) {
        $this->user_email = $email;

        $user_from_db = UserFinder::findByEmail($email);

        if ($user_from_db) {
            if (password_verify($password,$user_from_db->password_Field)) {
                return $user_from_db;
            }
        }
        return false;
    }

    private function login(UserRecord $user) {
        $this->user_record = $user;
        $this->user_id = $_SESSION['auth']['user_id'] = $user->id_Field;
        $_SESSION['auth']['user_email'] = $user->email_Field;
        $this->user_name = $_SESSION['auth']['user_name'] = $user->name_Field;
        $this->user_avatar = $_SESSION['auth']['user_avatar'] = $user->avatar_Field;
        $this->logged_in = true;
        header("Location: /");
        exit();
    }

    private function checkIfLoggedIn() {
        if (isset($_SESSION['auth']['user_email'])) {
            $this->user_id = $_SESSION['auth']['user_id'];
            $this->user_email = $_SESSION['auth']['user_email'];
            $this->user_name = $_SESSION['auth']['user_name'];
            $this->user_avatar = $_SESSION['auth']['user_avatar'];
            $this->logged_in = true;
        }
    }

    function logout() {
        unset($this->user_record);
        $this->user_id = null;
        $this->user_email = null;
        $this->user_name = null;
        $this->user_avatar = null;
        $this->logged_in = false;
        unset($_SESSION['auth']);
        header("Location: /");
        exit();
    }

    function isLoggedIn() {
        return $this->logged_in;
    }

    function getUserId() {
        if ($this->isLoggedIn()) {
            return $this->user_id;
        }
        return false;
    }

    function getUserName() {
        if ($this->isLoggedIn()) {
            return $this->user_name;
        }
        return false;
    }

    function getUserEmail() {
        if ($this->isLoggedIn()) {
            return $this->user_email;
        }
        return false;
    }

    function getUserAvatar() {
        if ($this->isLoggedIn()) {
            return $this->user_avatar;
        }
        return false;
    }

}