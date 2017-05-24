<?php

echo includeTemplate('../app/views/_templates/header.php',[
    'user' => $user
]);

echo
<<< EOD
<main class="container">
    <section class="promo">
        <p>Вы были успешно зарегистрированы! Зайдите на сайт на <a href='/users/login'>странице входа</a>
            , используя свои email и пароль.</p>
    </section>
</main>
EOD;

echo includeTemplate('../app/views/_templates/footer.php',[
    'categories' => $categories,
    'user' => $user
]);

