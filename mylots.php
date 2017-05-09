<?php

require_once 'config.php';

if (!isset($_SESSION['auth']['user_email'])) {
    header("HTTP/1.1 403 Forbidden");
    die("Страница доступна только для зарегистрированных пользователей!");
}

require_once 'data.php';

require_once 'functions.php';

?>

<?=includeTemplate('templates/header.php');?>

<?=includeTemplate('templates/my-lots.php',[
    'stakes' => isset($_COOKIE['stakes']) ? $_COOKIE['stakes'] : null,
    'lots' => $lots,
    'categories' => $categories
]);?>

<?=includeTemplate('templates/footer.php');?>


