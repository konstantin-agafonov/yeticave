<?php

echo includeTemplate('../Yeticave/App/Views/_templates/header.php',[
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

echo includeTemplate('../Yeticave/App/Views/_templates/footer.php',[
    'categories' => $categories,
    'user' => $user
]);

