<?php

require_once 'config.php';

$user = new Core\User('Db');

if ($user->isLoggedIn()) {
    $user->logout();
}
