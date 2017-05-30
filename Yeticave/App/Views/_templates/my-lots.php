<main>

    <?=includeTemplate('_templates/header-nav.php',[
        'categories' => $categories
    ]);?>

    <section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">

        <?php
        if ($stakes) {
            foreach ($stakes as $stake):?>

                <tr class="rates__item">
                    <td class="rates__info">
                        <div class="rates__img">
                            <img src="/public/uploads/<?=$stake['lot_pic'];?>" width="54" height="40"
                            alt="<?=htmlspecialchars($stake['lot_name']);?>">
                        </div>
                        <h3 class="rates__title">
                            <a href="/lot/<?=htmlspecialchars($stake['lot_id']);?>">
                                <?=htmlspecialchars($stake['lot_name']);?>
                            </a>
                        </h3>
                    </td>
                    <td class="rates__category">
                        <?=htmlspecialchars($stake['category_name']);?>
                    </td>
                    <td class="rates__timer">
                        <div class="timer timer--finishing">
                            <?=lotTimeRemaining();?>
                        </div>
                    </td>
                    <td class="rates__price">
                        <?=htmlspecialchars($stake['stake_sum']);?> р
                    </td>
                    <td class="rates__time">
                        <?= relativeTime(strtotime($stake['created_at'])); ?>
                    </td>
                </tr>

            <?php endforeach;
        } ?>

    </table>
  </section>

</main>