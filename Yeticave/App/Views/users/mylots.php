<?php

echo includeTemplate('../Yeticave/App/Views/_templates/header.php',[
    'user' => $user
]);

echo includeTemplate('../Yeticave/App/Views/_templates/my-lots.php',[
    'stakes' => $stakes,
    'categories' => $categories
]);

echo includeTemplate('../Yeticave/App/Views/_templates/footer.php',[
    'categories' => $categories,
    'user' => $user
]);

