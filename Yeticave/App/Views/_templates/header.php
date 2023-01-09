<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
    <link href="http://<?=$_SERVER['SERVER_NAME'];?>/public/css/normalize.min.css" rel="stylesheet">
    <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
    <link href="http://<?=$_SERVER['SERVER_NAME'];?>/public/css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="http://<?=$_SERVER['SERVER_NAME'];?>/public/js/script.js"></script>
</head>
<body>

<header class="main-header">
    <div class="main-header__container container">
        <h1 class="visually-hidden">YetiCave</h1>
        <a class="main-header__logo" href="/">
            <img src="http://<?=$_SERVER['SERVER_NAME'];?>/public/img/logo.svg" width="160" height="39"
                 alt="Логотип компании YetiCave">
        </a>
        <form class="main-header__search">
            <input type="search" name="search_string" placeholder="Поиск лота">
            <input class="main-header__search-btn" type="submit" name="find" value="Найти">
        </form>

        <?php if ($user->isLoggedIn()): ?>
            <a class="main-header__add-lot button" href="/lot/add">Добавить лот</a>
        <?php endif; ?>

        <nav class="user-menu">

            <?php if ($user->isLoggedIn()): ?>
                <div class="user-menu__image">
                    <img src="http://<?=$_SERVER['SERVER_NAME'];?>/public/uploads/<?= htmlspecialchars($user->getUserAvatar()); ?>"
                         width="40" height="40" alt="Пользователь">
                </div>
                <div class="user-menu__logged">
                    <p><a href="/users/mylots"><?= htmlspecialchars($user->getUserName()); ?></a></p>
                    <a href="/users/logout">Выйти</a>
                </div>
            <?php else: ?>
                <ul class="user-menu__list">
                    <li class="user-menu__item">
                        <a href="/users/signup">Регистрация</a>
                    </li>
                    <li class="user-menu__item">
                        <a href="/users/login">Вход</a>
                    </li>
                </ul>
            <?php endif; ?>
        </nav>
    </div>
</header>
