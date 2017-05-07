<?php

require_once 'config.php';

unset($_SESSION['auth']);

header("Location: /");
exit();