<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

error_reporting(E_ALL);

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

// db connection
define('DB_NAME','yeticave');
define('DB_PASS','9UNmULQIcWOVKSqp');
define('DB_HOST','localhost');
define('DB_USER','yeticave');

define('SMTP_HOST','smtp.yandex.ru');
define('SMTP_PORT','465');
define('SMTP_USER','vasily.barmaleev@yandex.ru');
define('SMTP_PASS','');

use Yeticave\Core\Db;
Db::init();

session_start();

