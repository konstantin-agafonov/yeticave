<?php

echo includeTemplate('../Yeticave/App/Views/_templates/header.php',[
'user' => $user
]);

echo includeTemplate('../Yeticave/App/Views/_templates/main.php',[
'lots' => $lots,
'categories' => $categories,
'lot_time_remaining' => $lot_time_remaining
]);

echo includeTemplate('../Yeticave/App/Views/_templates/footer.php',[
'categories' => $categories,
'user' => $user
]);
