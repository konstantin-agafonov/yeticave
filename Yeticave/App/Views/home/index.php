<?php

echo includeTemplate('_templates/header.php', [
    'user' => $user
]);

echo includeTemplate('_templates/main.php', [
    'lots' => $lots,
    'categories' => $categories,
    'lot_time_remaining' => $lot_time_remaining,
    'category_id' => $category_id
]);

echo includeTemplate('_templates/footer.php', [
    'categories' => $categories,
    'user' => $user
]);
