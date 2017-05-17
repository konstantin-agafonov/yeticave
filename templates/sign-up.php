<main>
    <?php
    echo includeTemplate('templates/header-nav.php', [
        'categories' => $data['categories']
    ]);
    ?>
    <form class="form container <?= $data['form_validated'] ? '' : ' form--invalid'; ?>"
          method="post" enctype="multipart/form-data"> <!-- form--invalid -->

        <h2>Регистрация нового аккаунта</h2>

        <div class="form__item <?= $data['fields']['email']['validated'] ? '' : 'form__item--invalid'; ?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail"
                   value="<?= $data['fields']['email']['validated'] ? $data['fields']['email']['value'] : ''; ?>">
            <span class="form__error">
                    <?= $data['fields']['email']['validated'] ? '' : $data['fields']['email']['error']; ?>
            </span>
        </div>

        <div class="form__item <?= $data['fields']['password']['validated'] ? '' : 'form__item--invalid'; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="password" placeholder="Введите пароль">
            <span class="form__error">
                    <?= $data['fields']['password']['validated'] ? '' : $data['fields']['password']['error']; ?>
            </span>
        </div>

        <div class="form__item <?= $data['fields']['name']['validated'] ? '' : 'form__item--invalid'; ?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="name" placeholder="Введите имя"
                   value="<?= $data['fields']['name']['validated'] ? $data['fields']['name']['value'] : ''; ?>">
            <span class="form__error">
                    <?= $data['fields']['name']['validated'] ? '' : $data['fields']['name']['error']; ?>
            </span>
        </div>

        <div class="form__item <?= $data['fields']['contacts']['validated'] ? '' : 'form__item--invalid'; ?>">
            <label for="message">Контактные данные*</label>
            <textarea id="contacts" name="contacts" placeholder="Напишите как с вами связаться"><?=
                $data['fields']['contacts']['validated'] ? $data['fields']['contacts']['value'] : '';
                ?></textarea>
            <span class="form__error">
                    <?= $data['fields']['contacts']['validated'] ? '' : $data['fields']['contacts']['error']; ?>
            </span>
        </div>

        <div class="form__item form__item--file form__item--last">
            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="../img/avatar.jpg" width="113" height="113" alt="Изображение лота">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" name="photo" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
        </div>

        <span class="form__error form__error--bottom" >Пожалуйста, исправьте ошибки в форме.</span>

        <button type="submit" class="button">Зарегистрироваться</button>

        <a class="text-link" href="login.php">Уже есть аккаунт</a>

    </form>
</main>