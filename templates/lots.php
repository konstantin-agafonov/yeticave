<main>

    <?php headerNav(); ?>

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
                    <p class="lot-item__description">
                        <?=(isset($data['lot']['description']))?$data['lot']['description']:'Нет описания';?>
                    </p>
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
                                    <?=number_format( (float)$data['lot']['price'], 2, '.', ' ');?>
                                </span>
                            </div>
                            <div class="lot-item__min-cost">
                                Мин. ставка <span>
                                        <?=(isset($data['lot']['step']))?number_format( (float)$data['lot']['step'], 2, '.', ' '):'Не определено';?>
                                    р</span>
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
                        <h3>История ставок (<span><?=count($data['bets']);?></span>)</h3>
                        <!-- заполните эту таблицу данными из массива $bets-->
                        <table class="history__list">

                            <?php if (!empty($data['bets'])): ?>
                                <?php foreach ($data['bets'] as &$bet): ?>
                                    <tr class="history__item">
                                        <td class="history__name"><?= htmlspecialchars($bet['name']); ?></td>
                                        <td class="history__price"><?= htmlspecialchars($bet['price']); ?> р</td>
                                        <td class="history__time"><?= relativeTime($bet['ts']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Нет истории ставок</p>
                            <?php endif; ?>

                        </table>
                    </div>
                </div>

            <?php else: ?>

                <h2>No data to display!</h2>

            <?php endif; ?>

        </div>
    </section>
</main>