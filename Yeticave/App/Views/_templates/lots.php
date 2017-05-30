<main>

    <?php
    echo includeTemplate('_templates/header-nav.php',[
            'categories' => $categories
    ]);
    ?>

    <section class="lot-item container">
        <div class="lot-item__content">

            <?php if ($lot): ?>

                <div class="lot-item__left">
                    <h2><?=htmlentities($lot->name_Field); ?></h2>
                    <div class="lot-item__image">
                        <img src="http://<?=$_SERVER['SERVER_NAME'];?>/public/uploads/<?=htmlentities($lot->pic_Field); ?>"
                             width="730" height="548" alt="<?=htmlentities($lot->name_Field); ?>">
                    </div>
                    <p class="lot-item__category">Категория:
                        <span><?=htmlspecialchars($lot->category_name_Field);?></span>
                    </p>
                    <p class="lot-item__description">
                        <?=($lot->description_Field)?htmlspecialchars($lot->description_Field):'Нет описания';?>
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
                                    <?= number_format(
                                            (float)$lot->start_price_Field,
                                            2, '.', ' '); ?>
                                </span>
                                </div>
                                <div class="lot-item__min-cost">
                                    Мин. ставка <span>
                                        <?= ($lot->stake_step_Field) ? number_format(
                                                (float)$lot->stake_step_Field,
                                            2, '.', ' ') : 'Не определено'; ?>
                                        р</span>
                                </div>
                            </div>

                            <?php if ($user->isLoggedIn() && (!$have_stake)) { ?>

                                <form class="lot-item__form" method="post" action="/lot/new-stake">
                                    <input type="hidden" name="lot_id" value="<?=htmlspecialchars($lot->id_Field);?>">
                                    <p class="lot-item__form-item">
                                        <label for="cost">Ваша ставка</label>
                                        <input id="cost" type="number" name="cost" min="0" step="0.01"
                                               placeholder="12 000">
                                    </p>
                                    <button type="submit" class="button">Сделать ставку</button>
                                </form>
                                <div style="color: red;clear: both;">
                                    <?php if (!empty($fields['cost']['errors'])) {
                                        foreach ($fields['cost']['errors'] as $error) { ?>
                                            <p>
                                                <?=htmlspecialchars($error);?>
                                            </p>
                                        <?php }
                                    } ?>
                                </div>

                            <?php } ?>

                        </div>


                    <div class="history">
                        <h3>История ставок (<span><?=count($stakes);?></span>)</h3>
                        <!-- заполните эту таблицу данными из массива $stakes-->
                        <table class="history__list">

                            <?php if (!empty($stakes)): ?>
                                <?php foreach ($stakes as &$bet): ?>
                                    <tr class="history__item">
                                        <td class="history__name">
                                            <?=htmlspecialchars($bet['user_name']);?>
                                        </td>
                                        <td class="history__price"><?= htmlspecialchars($bet['stake_sum']); ?> р</td>
                                        <td class="history__time"><?= relativeTime(strtotime($bet['created_at'])); ?></td>
                                    </tr>
                                <?php endforeach;
                                unset($bet); ?>
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