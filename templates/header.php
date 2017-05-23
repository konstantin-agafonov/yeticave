<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<header class="main-header">
    <div class="main-header__container container">
        <h1 class="visually-hidden">YetiCave</h1>
        <a class="main-header__logo" href="/">
            <img src="img/logo.svg" width="160" height="39" alt="Логотип компании YetiCave">
        </a>
        <form class="main-header__search" method="get" action="https://echo.htmlacademy.ru">
            <input type="search" name="search" placeholder="Поиск лота">
            <input class="main-header__search-btn" type="submit" name="find" value="Найти">
        </form>

        <?php if ($data['user']->isLoggedIn()): ?>
            <a class="main-header__add-lot button" href="add.php">Добавить лот</a>
        <?php endif; ?>

        <nav class="user-menu">

            <?php if ($data['user']->isLoggedIn()): ?>

                <div class="user-menu__image">
                    <img src="uploads/<?= $data['user']->getUserAvatar(); ?>" width="40" height="40" alt="Пользователь">
                </div>
                <div class="user-menu__logged">
                    <p><a href="mylots.php"><?= $data['user']->getUserName(); ?></a></p>
                    <a href="logout.php">Выйти</a>
                </div>

            <?php else: ?>

                <ul class="user-menu__list">
                    <li class="user-menu__item">
                        <a href="signup.php">Регистрация</a>
                    </li>
                    <li class="user-menu__item">
                        <a href="login.php">Вход</a>
                    </li>
                </ul>

            <?php endif; ?>

        </nav>



    </div>
</header>
