<?php

echo includeTemplate('../app/views/_templates/header.php',[
    'user' => $user
]);
echo includeTemplate('../app/views/_templates/add-lot.php',[
    'categories' => $categories,
    'form_validated' => $form_validated,
    'fields' => $fields,
    'file' => isset($file) ? $file : null
]);

echo includeTemplate('../app/views/_templates/footer.php',[
    'categories' => $categories,
    'user' => $user
]);
