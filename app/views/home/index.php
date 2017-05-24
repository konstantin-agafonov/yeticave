<?php

echo includeTemplate('../app/views/_templates/header.php',[
'user' => $user
]);

echo includeTemplate('../app/views/_templates/main.php',[
'lots' => $lots,
'categories' => $categories,
'lot_time_remaining' => $lot_time_remaining
]);

echo includeTemplate('../app/views/_templates/footer.php',[
'categories' => $categories,
'user' => $user
]);
