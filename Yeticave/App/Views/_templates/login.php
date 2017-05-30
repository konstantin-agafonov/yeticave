<main>

    <?=includeTemplate('_templates/header-nav.php', [
        'categories' => $categories
    ]);?>

    <form class="form container <?= $form_validated ? '' : ' form--invalid'; ?>" method="post">
        <h2>Вход</h2>

        <div class="form__item <?=$fields['email']['errors'] ? 'form__item--invalid' : ''; ?>">
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail"
                   value="<?=$fields['email']['value'] ? htmlspecialchars($fields['email']['value']) : ''; ?>">

            <?php
            if ($fields['email']['errors']) {
                foreach ($fields['email']['errors'] as $error) { ?>

                    <span class="form__error">
                        <?=htmlspecialchars($error);?>
                    </span>

            <?php }
            } ?>

        </div>

        <div class="form__item form__item--last <?=$fields['password']['errors'] ? 'form__item--invalid' : ''; ?>">
            <label for="password">Пароль*</label>

            <input id="password" type="password" name="password" placeholder="Введите пароль"
                   value="<?=$fields['password']['value'] ? htmlspecialchars($fields['password']['value']) : ''; ?>">

            <?php
            if ($fields['password']['errors']) {
                foreach ($fields['password']['errors'] as $error) { ?>

                    <span class="form__error">
                        <?=htmlspecialchars($error);?>
                    </span>

                <?php }
            } ?>

        </div>
        <div style="color: red;">
            <?= (!$user_validated && $form_validated) ? 'Неверные данные для входа' : ''; ?>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>

</main>