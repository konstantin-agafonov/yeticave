<?php

require_once 'config.php';
require_once 'functions.php';
require_once 'data.php';
require_once 'userdata.php';

if (!isset($_SESSION['auth']['user_email'])) {
    header("HTTP/1.1 403 Forbidden");
    die("Страница доступна только для зарегистрированных пользователей!");
}

$current_user_id = getSubarrayValueByAnotherValue(
    $users,
    'email',
    $_SESSION['auth']['user_email'],
    'id');

$stakes = db_select($db_conn,'select * from stakes where user_id = ?;',[$current_user_id]);

?>



<?=includeTemplate('templates/header.php');?>

<?=includeTemplate('templates/my-lots.php',[
    'stakes' => $stakes,
    'lots' => $lots,
    'categories' => $categories
]);?>

<?=includeTemplate('templates/footer.php',[
    'categories' => $categories
]);?>


