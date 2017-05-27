<main>

    <?=includeTemplate('../Yeticave/App/Views/_templates/header-nav.php',[
        'categories' => $data['categories']
    ]);?>

    <form class="form container <?= $data['form_validated'] ? '' : ' form--invalid'; ?>" method="post">
        <!-- form--invalid -->
        <h2>Вход</h2>

        <div class="form__item <?=isset($data['fields']['email']['errors']) ? 'form__item--invalid' : ''; ?>">
            <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail"
                   value="<?=isset($data['fields']['email']['value']) ? $data['fields']['email']['value'] : ''; ?>">

            <?php
            if (isset($data['fields']['email']['errors'])) {
                foreach ($data['fields']['email']['errors'] as $error) { ?>

                    <span class="form__error">
                        <?=$error;?>
                    </span>

            <?php }
            } ?>

        </div>

        <div class="form__item form__item--last <?=isset($data['fields']['password']['errors']) ? 'form__item--invalid' : ''; ?>">
            <label for="password">Пароль*</label>

            <input id="password" type="password" name="password" placeholder="Введите пароль"
                   value="<?=isset($data['fields']['password']['value']) ? $data['fields']['password']['value'] : ''; ?>">

            <?php
            if (isset($data['fields']['password']['errors'])) {
                foreach ($data['fields']['password']['errors'] as $error) { ?>

                    <span class="form__error">
                        <?=$error;?>
                    </span>

                <?php }
            } ?>

        </div>
        <div style="color: red;">
            <?= ($data['user_validated'] === false) ? 'Неверные данные для входа' : ''; ?>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>

</main>