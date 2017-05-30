<main>

    <?= includeTemplate('_templates/header-nav.php', [
        'categories' => $categories
    ]); ?>

    <form class="form form--add-lot container <?= $form_validated ? '' : ' form--invalid'; ?>"
          method="post" enctype="multipart/form-data">

        <h2>Добавление лота</h2>

        <div class="form__container-two">

            <div class="form__item <?=$fields['lot-name']['errors'] ? 'form__item--invalid' : ''; ?>">

                <label for="lot-name">Наименование</label>
                <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота"
                       value="<?= $fields['lot-name']['value'] ? htmlspecialchars($fields['lot-name']['value']) : ''; ?>">

                <?php
                if ($fields['lot-name']['errors']) {
                    foreach ($fields['lot-name']['errors'] as $error) { ?>

                        <span class="form__error">
                            <?=htmlspecialchars($error);?>
                        </span>

                    <?php }
                } ?>

            </div>

            <?php
            $entered_category = $fields['category']['value'] ? $fields['category']['value'] : null;
            ?>

            <div class="form__item <?=($fields['category']['errors']
                    || (!$entered_category && !$form_validated)) ? 'form__item--invalid' : ''; ?>">

                <label for="category">Категория</label>

                <select id="category" name="category">

                    <option value="" <?= ($entered_category) ? '' : 'selected'; ?> disabled>Выберите категорию
                    </option>

                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['id']); ?>"
                            <?= ((int)$entered_category === $category['id']) ? ' selected' : ''; ?>>
                            <?= htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>

                </select>

                <?php if (!$entered_category && !$form_validated) { ?>
                    <span class="form__error">
                            Необходимо выбрать категорию!
                    </span>
                <?php } else {
                    if ($fields['category']['errors']) {
                        foreach ($fields['category']['errors'] as $error) : ?>

                            <span class="form__error">
                                  <?= htmlspecialchars($error); ?>
                               </span>

                        <?php endforeach;
                    }
                } ?>

            </div>

        </div>

        <div class="form__item form__item--wide <?=$fields['message']['errors'] ? 'form__item--invalid' : ''; ?>">

            <label for="message">Описание</label>
            <textarea id="message" name="message" placeholder="Напишите описание лота">
                <?= $fields['message']['value'] ? htmlspecialchars($fields['message']['value']) : ''; ?>
            </textarea>

            <?php
            if ($fields['message']['errors']) {
                foreach ($fields['message']['errors'] as $error) : ?>

                    <span class="form__error">
                        <?= htmlspecialchars($error); ?>
                    </span>

                <?php endforeach;
            } ?>

        </div>

        <div class="form__item form__item--file"> <!-- form__item--uploaded -->

            <label>Изображение</label>

            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="../public/img/avatar.jpg" width="113" height="113" alt="Изображение лота">
                </div>
            </div>

            <div class="form__input-file">
                <input class="visually-hidden" name="photo" type="file" id="photo2">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>

        </div>

        <span style="color:red;"><?= ($file['error'] !== null) ? $file['error'] : ''; ?></span>

        <div class="form__container-three">

            <div class="form__item form__item--small <?=$fields['lot-rate']['errors'] ? 'form__item--invalid' : ''; ?>">

                <label for="lot-rate">Начальная цена</label>
                <input id="lot-rate" type="number" name="lot-rate" placeholder="0" min="0" step="0.01"
                       value="<?= $fields['lot-rate']['value'] ? number_format($fields['lot-rate']['value'], 2,
                           '.', ' ') : ''; ?>">

                <?php
                if ($fields['lot-rate']['errors']) {
                    foreach ($fields['lot-rate']['errors'] as $error) : ?>

                        <span class="form__error">
                            <?=htmlspecialchars($error);?>
                        </span>

                    <?php endforeach;
                } ?>

            </div>

            <div class="form__item form__item--small <?=$fields['lot-step']['errors'] ? 'form__item--invalid' : ''; ?>">

                <label for="lot-step">Шаг ставки</label>
                <input id="lot-step" type="number" name="lot-step" placeholder="0" min="0" step="0.01"
                       value="<?= $fields['lot-step']['value'] ? number_format($fields['lot-step']['value'], 2,
                           '.', ' ') : ''; ?>">

                <?php
                if ($fields['lot-step']['errors']) {
                    foreach ($fields['lot-step']['errors'] as $error) : ?>

                        <span class="form__error">
                            <?=htmlspecialchars($error);?>
                        </span>

                    <?php endforeach;
                } ?>

            </div>

            <div class="form__item <?=$fields['lot-date']['errors'] ? 'form__item--invalid' : ''; ?>">

                <label for="lot-date">Дата завершения</label>
                <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="dd.mm.yyyy"
                       value="<?= $fields['lot-date']['value'] ? htmlspecialchars($fields['lot-date']['value']) : ''; ?>">

                <?php
                if ($fields['lot-date']['errors']) {
                    foreach ($fields['lot-date']['errors'] as $error) : ?>

                        <span class="form__error">
                            <?=htmlspecialchars($error);?>
                        </span>

                    <?php endforeach;
                } ?>

            </div>

        </div>

        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button" name="submit">Добавить лот</button>

    </form>

</main>
