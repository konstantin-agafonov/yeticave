<?php

declare(strict_types=1);

require_once "functions.php";

error_reporting(E_ALL);

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

// default date format
define('DDF','d-m-Y H:i:s');

// db connection
define('DB_NAME','yeticave');
define('DB_PASS','9UNmULQIcWOVKSqp');
define('DB_HOST','localhost');
define('DB_USER','yeticave');

use Core\Db;
Db::init();

$categories = Db::select('select id,name from categories;');

session_start();

