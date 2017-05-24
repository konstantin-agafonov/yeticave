<?php

echo includeTemplate('../app/views/_templates/header.php',[
    'user' => $user
]);
echo includeTemplate('../app/views/_templates/lots.php', [
    'stakes' => $stakes,
    'lot' => $lot,
    'fields' => $fields,
    'have_stake' => $have_stake,
    'categories' => $categories,
    'user' => $user
]);
echo includeTemplate('../app/views/_templates/footer.php',[
    'categories' => $categories,
    'user' => $user
]);
