<?php

require_once 'config.php';

unset($_SESSION['auth']);
setcookie('stakes','',strtotime("-30 days"));
/*unset($_COOKIE['stakes']);*/

header("Location: /");
exit();