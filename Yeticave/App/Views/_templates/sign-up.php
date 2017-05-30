<main>
    <?php
    echo includeTemplate('_templates/header-nav.php', [
        'categories' => $categories
    ]);
    ?>
    <form class="form container <?= $form_validated ? '' : ' form--invalid'; ?>"
          method="post" enctype="multipart/form-data"> <!-- form--invalid -->

        <h2>Регистрация нового аккаунта</h2>

        <div class="form__item <?= $fields['email']['errors'] ? 'form__item--invalid' : ''; ?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail"
                   value="<?= $fields['email']['value'] ? htmlspecialchars($fields['email']['value']) : ''; ?>">

            <?php
            if ($fields['email']['errors']) {
                foreach ($fields['email']['errors'] as $error) { ?>

                    <span class="form__error">
                            <?=htmlspecialchars($error);?>
                        </span>

                <?php }
            } ?>

        </div>

        <div class="form__item <?= $fields['password']['errors'] ? 'form__item--invalid' : ''; ?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="password" placeholder="Введите пароль">

            <?php
            if ($fields['password']['errors']) {
                foreach ($fields['password']['errors'] as $error) { ?>

                    <span class="form__error">
                        <?=htmlspecialchars($error);?>
                    </span>

                <?php }
            } ?>

        </div>

        <div class="form__item <?= $fields['name']['errors'] ? 'form__item--invalid' : ''; ?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="name" placeholder="Введите имя"
                   value="<?= $fields['name']['value'] ? htmlspecialchars($fields['name']['value']) : ''; ?>">

            <?php
            if ($fields['name']['errors']) {
                foreach ($fields['name']['errors'] as $error) { ?>

                    <span class="form__error">
                            <?=htmlspecialchars($error);?>
                        </span>

                <?php }
            } ?>

        </div>

        <div class="form__item <?= $fields['contacts']['errors'] ? 'form__item--invalid' : ''; ?>">
            <label for="message">Контактные данные*</label>
            <textarea id="contacts" name="contacts" placeholder="Напишите как с вами связаться"><?=
                $fields['contacts']['value'] ? htmlspecialchars($fields['contacts']['value']) : '';
                ?></textarea>

            <?php
            if ($fields['contacts']['errors']) {
                foreach ($fields['contacts']['errors'] as $error) { ?>

                    <span class="form__error">
                            <?=htmlspecialchars($error);?>
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
                <?=$file['error'] ? $file['error'] : '';?>
            </span>
        </div>

        <span class="form__error form__error--bottom" >Пожалуйста, исправьте ошибки в форме.</span>

        <button type="submit" class="button">Зарегистрироваться</button>

        <a class="text-link" href="/users/login">Уже есть аккаунт</a>

    </form>
</main>