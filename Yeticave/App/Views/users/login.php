<?php

echo includeTemplate('_templates/header.php', [
    'user' => $user
]);

echo includeTemplate('_templates/login.php', [
    'fields' => $fields,
    'form_validated' => $form_validated,
    'user_validated' => $user_validated,
    'categories' => $categories
]);

echo includeTemplate('_templates/footer.php', [
    'categories' => $categories,
    'user' => $user
]);

