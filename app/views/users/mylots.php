<?php

echo includeTemplate('../app/views/_templates/header.php',[
    'user' => $user
]);

echo includeTemplate('../app/views/_templates/my-lots.php',[
    'stakes' => $stakes,
    'categories' => $categories
]);

echo includeTemplate('../app/views/_templates/footer.php',[
    'categories' => $categories,
    'user' => $user
]);

