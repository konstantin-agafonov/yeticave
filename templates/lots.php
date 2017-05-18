<main>

    <?php
    echo includeTemplate('templates/header-nav.php',[
            'categories' => $data['categories']
    ]);
    ?>

    <section class="lot-item container">
        <div class="lot-item__content">

            <?php if ($data['lot']): ?>

                <div class="lot-item__left">
                    <h2><?=htmlentities($data['lot']['name']); ?></h2>
                    <div class="lot-item__image">
                        <img src="<?=htmlentities($data['lot']['pic']); ?>" width="730" height="548" alt="<?=htmlentities($data['lot']['name']); ?>">
                    </div>
                    <p class="lot-item__category">Категория:
                        <span><?=htmlspecialchars($data['lot']['category_name']);?></span>
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
                                    <?= number_format((float)$data['lot']['start_price'], 2, '.', ' '); ?>
                                </span>
                                </div>
                                <div class="lot-item__min-cost">
                                    Мин. ставка <span>
                                        <?= (isset($data['lot']['stake_step'])) ? number_format((float)$data['lot']['stake_step'],
                                            2, '.', ' ') : 'Не определено'; ?>
                                        р</span>
                                </div>
                            </div>

                            <?php if (isset($_SESSION['auth']['user_email']) && (!$data['have_stake'])): ?>

                                <form class="lot-item__form" method="post" action="lot.php">
                                    <input type="hidden" name="lot_id" value="<?=$data['lot']['id'];?>">
                                    <p class="lot-item__form-item">
                                        <label for="cost">Ваша ставка</label>
                                        <input id="cost" type="number" name="cost" min="0" step="0.01"
                                               placeholder="12 000">
                                    </p>
                                    <button type="submit" class="button">Сделать ставку</button>
                                </form>
                                <div style="color: red;clear: both;">
                                    <?=isset($data['fields']['cost']['error']) ? $data['fields']['cost']['error'] : '';?>
                                </div>

                            <?php endif; ?>

                        </div>


                    <div class="history">
                        <h3>История ставок (<span><?=count($data['stakes']);?></span>)</h3>
                        <!-- заполните эту таблицу данными из массива $stakes-->
                        <table class="history__list">

                            <?php if (!empty($data['stakes'])): ?>
                                <?php foreach ($data['stakes'] as &$bet): ?>
                                    <tr class="history__item">
                                        <td class="history__name">
                                            <?=$bet['user_name'];?>
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