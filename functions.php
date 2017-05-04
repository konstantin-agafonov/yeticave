<?php

function includeTemplate(string $path2template = null, array $data = null) : string {
    if (!file_exists($path2template)) {
        return '';
    }
    ob_start();
    include $path2template;
    $template = ob_get_clean();
    return $template;
}

function relativeTime(int $time): string
{
    $now = time();
    $diff = $now - $time;
    if ((($diff) / (60 * 60)) >= 24) {
        return date('d.m.y в H:i', $time);
    }
    if (($diff / 60) <= 60) {
        return round($diff / 60) . " минут назад";
    }
    return round($diff / (60 * 60)) . " часов назад";
}

function headerNav(){
    ?>
    <nav class="nav">
        <ul class="nav__list container">
            <li class="nav__item">
                <a href="">Доски и лыжи</a>
            </li>
            <li class="nav__item">
                <a href="">Крепления</a>
            </li>
            <li class="nav__item">
                <a href="">Ботинки</a>
            </li>
            <li class="nav__item">
                <a href="">Одежда</a>
            </li>
            <li class="nav__item">
                <a href="">Инструменты</a>
            </li>
            <li class="nav__item">
                <a href="">Разное</a>
            </li>
        </ul>
    </nav>
    <?php
}
