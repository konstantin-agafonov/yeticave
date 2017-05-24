<?php

echo includeTemplate('../app/views/_templates/header.php',[
    'user' => $user
]);

echo includeTemplate('../app/views/_templates/sign-up.php', [
    'categories' => $categories,
    'fields' => $fields,
    'form_validated' => $form_validated,
    'file' => isset($file) ? $file : null
]);

echo includeTemplate('../app/views/_templates/footer.php',[
    'categories' => $categories,
    'user' => $user
]);

