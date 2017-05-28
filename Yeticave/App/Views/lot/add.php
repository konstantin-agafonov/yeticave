<?php

echo includeTemplate('../Yeticave/App/Views/_templates/header.php',[
    'user' => $user
]);

echo includeTemplate('../Yeticave/App/Views/_templates/add-lot.php',[
    'categories' => $categories,
    'form_validated' => $form_validated,
    'fields' => $fields,
    'file' => isset($file) ? $file : null
]);

echo includeTemplate('../Yeticave/App/Views/_templates/footer.php',[
    'categories' => $categories,
    'user' => $user
]);
