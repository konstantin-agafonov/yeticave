<main>
    <?php
    echo includeTemplate('../Yeticave/App/Views/_templates/header-nav.php', [
        'categories' => $data['categories']
    ]);
    ?>
    <form class="form container <?= $data['form_validated'] ? '' : ' form--invalid'; ?>"
          method="post" enctype="multipart/form-data"> <!-- form--invalid -->

        <h2>Регистрация нового аккаунта</h2>

        <div class="form__item <?= isset($data['fields']['email']['errors']) ? 'form__item--invalid' : ''; ?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail"
                   value="<?= $data['fields']['email']['value'] ? $data['fields']['email']['value'] : ''; ?>">

            <?php
            if (isset($data['fields']['email']['errors'])) {
                foreach ($data['fields']['email']['errors'] as $error) { ?>

                    <span class="form__error">
                            <?=$error;?>
                        </span>

                <?php }
            } ?>

        </div>

        <div class="form__item <?= $data['fields']['password']['errors'] ? 'form__item--invalid' : ''; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="password" placeholder="Введите пароль">

            <?php
            if (isset($data['fields']['password']['errors'])) {
                foreach ($data['fields']['password']['errors'] as $error) { ?>

                    <span class="form__error">
                        <?=$error;?>
                    </span>

                <?php }
            } ?>

        </div>

        <div class="form__item <?= $data['fields']['name']['errors'] ? 'form__item--invalid' : ''; ?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="name" placeholder="Введите имя"
                   value="<?= $data['fields']['name']['value'] ? $data['fields']['name']['value'] : ''; ?>">

            <?php
            if (isset($data['fields']['name']['errors'])) {
                foreach ($data['fields']['name']['errors'] as $error) { ?>

                    <span class="form__error">
                            <?=$error;?>
                        </span>

                <?php }
            } ?>

        </div>

        <div class="form__item <?= $data['fields']['contacts']['errors'] ? 'form__item--invalid' : ''; ?>">
            <label for="message">Контактные данные*</label>
            <textarea id="contacts" name="contacts" placeholder="Напишите как с вами связаться"><?=
                $data['fields']['contacts']['value'] ? $data['fields']['contacts']['value'] : '';
                ?></textarea>

            <?php
            if (isset($data['fields']['contacts']['errors'])) {
                foreach ($data['fields']['contacts']['errors'] as $error) { ?>

                    <span class="form__error">
                            <?=$error;?>
                        </span>

                <?php }
            } ?>

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
            <span style="color: red;">
                <?=isset($data['file']['error']) ? $data['file']['error'] : '';?>
            </span>
        </div>

        <span class="form__error form__error--bottom" >Пожалуйста, исправьте ошибки в форме.</span>

        <button type="submit" class="button">Зарегистрироваться</button>

        <a class="text-link" href="/users/login">Уже есть аккаунт</a>

    </form>
</main>