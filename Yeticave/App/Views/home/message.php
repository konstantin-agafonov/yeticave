<?php

echo includeTemplate('_templates/header.php', [
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

echo includeTemplate('_templates/footer.php', [
    'categories' => $categories,
    'user' => $user
]);


