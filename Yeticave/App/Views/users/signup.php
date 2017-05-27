<?php

echo includeTemplate('../Yeticave/App/Views/_templates/header.php',[
    'user' => $user
]);

echo includeTemplate('../Yeticave/App/Views/_templates/sign-up.php', [
    'categories' => $categories,
    'fields' => $fields,
    'form_validated' => $form_validated,
    'file' => isset($file) ? $file : null
]);

echo includeTemplate('../Yeticave/App/Views/_templates/footer.php',[
    'categories' => $categories,
    'user' => $user
]);

