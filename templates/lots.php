<main>
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
    <section class="lot-item container">
        <div class="lot-item__content">

            <?php if ($data['lot']): ?>

                <div class="lot-item__left">
                    <h2><?=htmlentities($data['lot']['name']); ?></h2>
                    <div class="lot-item__image">
                        <img src="<?=htmlentities($data['lot']['pic']); ?>" width="730" height="548" alt="<?=htmlentities($data['lot']['name']); ?>">
                    </div>
                    <p class="lot-item__category">Категория:
                        <span><?=htmlspecialchars($data['category']);?></span>
                    </p>
                    <p class="lot-item__description">Легкий маневренный сноуборд, готовый дать жару в любом парке,
                        растопив
                        снег
                        мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет
                        этот
                        снаряд
                        отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом
                        кэмбер
                        позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не
                        останется,
                        просто
                        посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла
                        равнодушным.</p>
                </div>
                <div class="lot-item__right">
                    <div class="lot-item__state">
                        <div class="lot-item__timer timer">
                            10:54:12
                        </div>
                        <div class="lot-item__cost-state">
                            <div class="lot-item__rate">
                                <span class="lot-item__amount">Текущая цена</span>
                                <span class="lot-item__cost">
                                    <?=number_format( (float)$data['lot']['price'], 0, '.', ' ');?>
                                </span>
                            </div>
                            <div class="lot-item__min-cost">
                                Мин. ставка <span>12 000 р</span>
                            </div>
                        </div>
                        <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post">
                            <p class="lot-item__form-item">
                                <label for="cost">Ваша ставка</label>
                                <input id="cost" type="number" name="cost" placeholder="12 000">
                            </p>
                            <button type="submit" class="button">Сделать ставку</button>
                        </form>
                    </div>
                    <div class="history">
                        <h3>История ставок (<span>4</span>)</h3>
                        <!-- заполните эту таблицу данными из массива $bets-->
                        <table class="history__list">

                            <?php foreach ($data['bets'] as &$bet): ?>
                                <tr class="history__item">
                                    <td class="history__name"><?= htmlspecialchars($bet['name']); ?></td>
                                    <td class="history__price"><?= htmlspecialchars($bet['price']); ?> р</td>
                                    <td class="history__time"><?= relativeTime($bet['ts']); ?></td>
                                </tr>
                            <?php endforeach; ?>

                        </table>
                    </div>
                </div>

            <?php else: ?>

                <h2>No data to display!</h2>

            <?php endif; ?>

        </div>
    </section>
</main>