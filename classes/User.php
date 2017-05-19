<?php

class User {

    private $db;
    public  $user_name;
    public  $user_id;
    public  $user_email;
    public  $user_avatar;
    public  $logged_in = false;
    public  $login_error = null;

    function __construct(Db $db,string $email = null,string $password = null) {

        $this->db = $db;

        if ($email && $password) {
            if ($authenticated_user = $this->authenticate($email,$password)) {
                $this->login($authenticated_user);
            } else {
                $this->login_error = "Пользователь не найден!";
            }
        } else {
            $this->checkIfLoggedIn();
        }

    }

    private function authenticate(string $email,string $password) {
        $this->user_email = $email;
        $user_from_db = $this->db->select('select * from users where email= ?;',[$this->user_email]);
        if ($user_from_db) {
            if (password_verify($password,$user_from_db[0]['password'])) {
                return $user_from_db[0];
            }
        }
        return false;
    }

    private function login(array $user) {
        $this->user_id = $_SESSION['auth']['user_id'] = $user['id'];
        $_SESSION['auth']['user_email'] = $user['email'];
        $this->user_name = $_SESSION['auth']['user_name'] = $user['name'];
        $this->user_avatar = $_SESSION['auth']['user_avatar'] = $user['avatar'];
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
        $this->user_id = null;
        $this->user_email = null;
        $this->user_name = null;
        $this->user_avatar = null;
        $this->logged_in = false;
        unset($_SESSION['auth']);
        header("Location: /");
        exit();
    }

}