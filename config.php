<?php

declare(strict_types=1);

error_reporting(E_ALL);

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

// default date format
define('DDF','d-m-Y H:i:s');

session_start();
