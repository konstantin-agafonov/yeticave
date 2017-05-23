<?php

require_once 'config.php';

use Core\User;
use Core\Db;

$user = new User('Db');

if (!$user->isLoggedIn()) {
    header("HTTP/1.1 403 Forbidden");
    die("Страница доступна только для зарегистрированных пользователей!");
}

$stakes = Db::select(
<<< EOD
select  stakes.*,
        lots.pic as lot_pic,
        lots.name as lot_name,
        categories.name as category_name
from stakes
left join lots on stakes.lot_id = lots.id
left join categories on lots.category_id = categories.id
where user_id = ?;
EOD
    ,[$user->getUserId()]
);

echo includeTemplate('templates/header.php',[
    'user' => $user
]);

echo includeTemplate('templates/my-lots.php',[
    'stakes' => $stakes,
    'categories' => $categories
]);

echo includeTemplate('templates/footer.php',[
    'categories' => $categories,
    'user' => $user
]);



