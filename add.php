<?php

require_once 'config.php';

require_once 'data.php';

require_once 'functions.php'; ?>

<?=includeTemplate('templates/header.php');?>

<?=includeTemplate('templates/add-lot.php',[
    'categories' => $categories
]);?>

<?=includeTemplate('templates/footer.php');
