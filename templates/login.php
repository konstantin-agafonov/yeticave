<main>

    <?=includeTemplate('templates/header-nav.php',[
        'categories' => $data['categories']
    ]);?>

    <form class="form container <?= $data['form_validated'] ? '' : ' form--invalid'; ?>" method="post">
        <!-- form--invalid -->
        <h2>Вход</h2>
        <div class="form__item <?= $data['fields']['email']['validated'] ? '' : 'form__item--invalid'; ?>">
            <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail"
                   value="<?= $data['fields']['email']['validated'] ? $data['fields']['email']['value'] : ''; ?>">
            <span class="form__error">
                <?= $data['fields']['email']['validated'] ? '' : $data['fields']['email']['error']; ?>
            </span>
        </div>
        <div class="form__item form__item--last <?= $data['fields']['password']['validated'] ? '' : 'form__item--invalid'; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="password" placeholder="Введите пароль"
                   value="<?= $data['fields']['password']['validated'] ? $data['fields']['password']['value'] : ''; ?>">
            <span class="form__error">
                <?= $data['fields']['password']['validated'] ? '' : $data['fields']['password']['error']; ?>
            </span>
        </div>
        <div style="color: red;">
            <?= ($data['user_validated'] === false) ? 'Неверные данные для входа' : ''; ?>
        </div>
        <button type="submit" class="button">Войти</button>
    </form>

</main>