<?php

echo includeTemplate('../app/views/_templates/header.php',[
    'user' => isset($user) ? $user : new Core\User('Db')
]);?>

<?=includeTemplate('../app/views/_templates/login.php',[
    'fields' => $fields,
    'form_validated' => $form_validated,
    'user_validated' => isset($user) ? $user->isLoggedIn() : true,
    'categories' => $categories
]);?>

<?=includeTemplate('../app/views/_templates/footer.php',[
    'categories' => $categories,
    'user' => isset($user) ? $user : new Core\User('Db')
]);?>
