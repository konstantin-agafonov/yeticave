<?php

// пользователи для аутентификации

$users = db_select($db_conn,'select * from users;');