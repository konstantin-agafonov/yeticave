<?php

echo includeTemplate('_templates/header.php', [
    'user' => $user
]);

echo includeTemplate('_templates/my-lots.php', [
    'stakes' => $stakes,
    'categories' => $categories
]);

echo includeTemplate('_templates/footer.php', [
    'categories' => $categories,
    'user' => $user
]);

