<?php

echo includeTemplate('_templates/header.php', [
    'user' => $user
]);

echo includeTemplate('_templates/sign-up.php', [
    'categories' => $categories,
    'fields' => $fields,
    'form_validated' => $form_validated,
    'file' => $file
]);

echo includeTemplate('_templates/footer.php', [
    'categories' => $categories,
    'user' => $user
]);

