<?php

echo includeTemplate('../Yeticave/App/Views/_templates/header.php',[
    'user' => isset($user) ? $user : new Yeticave\Core\User('Db')
]);?>

<?=includeTemplate('../Yeticave/App/Views/_templates/login.php',[
    'fields' => $fields,
    'form_validated' => $form_validated,
    'user_validated' => isset($user) ? $user->isLoggedIn() : true,
    'categories' => $categories
]);?>

<?=includeTemplate('../Yeticave/App/Views/_templates/footer.php',[
    'categories' => $categories,
    'user' => isset($user) ? $user : new Yeticave\Core\User('Db')
]);?>
