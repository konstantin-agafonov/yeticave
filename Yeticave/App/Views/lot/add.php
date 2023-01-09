<?php

echo includeTemplate('_templates/header.php', [
    'user' => $user
]);

echo includeTemplate('_templates/add-lot.php', [
    'categories' => $categories,
    'form_validated' => $form_validated,
    'fields' => $fields,
    'file' => $file
]);

echo includeTemplate('_templates/footer.php', [
    'categories' => $categories,
    'user' => $user
]);

