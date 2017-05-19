<?php

require_once 'config.php';

$user = new User($db);

if ($user->logged_in) {
    $user->logout();
}
