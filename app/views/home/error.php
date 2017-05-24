<?php

echo includeTemplate('../app/views/_templates/header.php',[
    'user' => $user
]);

echo
<<< EOD
<main class="container">
    <section class="promo">
        {$message}
    </section>
</main>
EOD;

echo includeTemplate('../app/views/_templates/footer.php',[
    'categories' => $categories,
    'user' => $user
]);

