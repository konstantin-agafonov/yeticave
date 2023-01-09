<?php

echo includeTemplate('_templates/header.php', [
    'user' => $user
]);

echo includeTemplate('_templates/lots.php', [
    'stakes' => $stakes,
    'lot' => $lot,
    'fields' => $fields,
    'have_stake' => $have_stake,
    'categories' => $categories,
    'user' => $user
]);

echo includeTemplate('_templates/footer.php', [
    'categories' => $categories,
    'user' => $user
]);
