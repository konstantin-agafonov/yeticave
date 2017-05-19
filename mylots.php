<?php

require_once 'config.php';

if (!isset($_SESSION['auth']['user_email'])) {
    header("HTTP/1.1 403 Forbidden");
    die("Страница доступна только для зарегистрированных пользователей!");
}

$stakes = $db->select(
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
    ,[$_SESSION['auth']['user_id']]
);

echo includeTemplate('templates/header.php');

echo includeTemplate('templates/my-lots.php',[
    'stakes' => $stakes,
    'categories' => $categories
]);

echo includeTemplate('templates/footer.php',[
    'categories' => $categories
]);



