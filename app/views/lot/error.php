<?php

echo includeTemplate('../app/views/_templates/header.php',[
    'user' => $user
]);

echo
<<< EOD
<main class="container">
    <section class="promo">
        <p>Ошибка при обработке формы! <a href='/'>На главную</a></p>
    </section>
</main>
EOD;

echo includeTemplate('../app/views/_templates/footer.php',[
    'categories' => $categories,
    'user' => $user
]);

