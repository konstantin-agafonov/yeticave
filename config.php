<?php

declare(strict_types=1);

error_reporting(E_ALL);

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

// default date format
define('DDF','d-m-Y H:i:s');

// db connection
define('DB_NAME','yeticave');
define('DB_PASS','9UNmULQIcWOVKSqp');
define('DB_SERVER','localhost');
define('DB_USER','yeticave');

$db_conn = mysqli_connect(DB_SERVER, DB_USER,DB_PASS,DB_NAME);
if ($db_conn == false){
    die("Ошибка подключения: " . mysqli_connect_error());
}

session_start();
