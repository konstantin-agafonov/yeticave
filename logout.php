<?php

require_once 'config.php';

unset($_SESSION['auth']);
setcookie('stakes','',strtotime("-30 days"));

header("Location: /");
exit();