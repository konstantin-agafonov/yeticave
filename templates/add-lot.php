<main>

    <?= includeTemplate('templates/header-nav.php'); ?>

    <form class="form form--add-lot container <?= $data['form_validated'] ? '' : ' form--invalid'; ?>" action="add.php"
          method="post" enctype="multipart/form-data"> <!-- form--invalid -->

        <h2>Добавление лота</h2>

        <div class="form__container-two">

            <div class="form__item <?= $data['fields']['lot-name']['validated'] ? '' : 'form__item--invalid'; ?>">
                <!-- form__item--invalid -->

                <label for="lot-name">Наименование</label>
                <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота"
                       value="<?= $data['fields']['lot-name']['validated'] ? $data['fields']['lot-name']['value'] : ''; ?>">
                <span class="form__error"><?= $data['fields']['lot-name']['validated'] ? '' : $data['fields']['lot-name']['error']; ?></span>

            </div>

            <div class="form__item <?= $data['fields']['category']['validated'] ? '' : 'form__item--invalid'; ?>">

                <label for="category">Категория</label>

                <?php
                $entered_category = $data['fields']['category']['validated'] ? $data['fields']['category']['value'] : null;
                ?>

                <select id="category" name="category">

                    <option value="" <?= ($entered_category) ? '' : 'selected'; ?> disabled>Выберите категорию
                    </option>

                    <?php foreach ($data['categories'] as $index => $category): ?>
                        <option value="<?= $index; ?>"
                            <?= ($entered_category === $index) ? ' selected' : ''; ?>>
                            <?= htmlspecialchars($category); ?>
                        </option>
                    <?php endforeach; ?>

                </select>
                <span class="form__error"><?= $data['fields']['category']['validated'] ? '' : $data['fields']['category']['error']; ?></span>

            </div>

        </div>

        <div class="form__item form__item--wide <?= $data['fields']['message']['validated'] ? '' : 'form__item--invalid'; ?>">

            <label for="message">Описание</label>
            <textarea id="message" name="message"
                      placeholder="Напишите описание лота"><?= $data['fields']['message']['validated'] ? $data['fields']['message']['value'] : ''; ?></textarea>
            <span class="form__error"><?= $data['fields']['message']['validated'] ? '' : $data['fields']['message']['error']; ?></span>

        </div>

        <div class="form__item form__item--file"> <!-- form__item--uploaded -->

            <label>Изображение</label>

            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="../img/avatar.jpg" width="113" height="113" alt="Изображение лота">
                </div>
            </div>

            <div class="form__input-file">
                <input class="visually-hidden" name="photo" type="file" id="photo2">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>

        </div>

        <span style="color:red;"><?= (isset($data['file']['error'])) ? $data['file']['error'] : ''; ?></span>

        <div class="form__container-three">

            <div class="form__item form__item--small <?= $data['fields']['lot-rate']['validated'] ? '' : 'form__item--invalid'; ?>">

                <label for="lot-rate">Начальная цена</label>
                <input id="lot-rate" type="number" name="lot-rate" placeholder="0" min="0" step="0.01"
                       value="<?= $data['fields']['lot-rate']['validated'] ? number_format($data['fields']['lot-rate']['value'], 2,
                           '.', ' ') : ''; ?>">
                <span class="form__error"><?= $data['fields']['lot-rate']['validated'] ? '' : $data['fields']['lot-rate']['error']; ?></span>

            </div>

            <div class="form__item form__item--small <?= $data['fields']['lot-step']['validated'] ? '' : 'form__item--invalid'; ?>">

                <label for="lot-step">Шаг ставки</label>
                <input id="lot-step" type="number" name="lot-step" placeholder="0" min="0" step="0.01"
                       value="<?= $data['fields']['lot-step']['validated'] ? number_format($data['fields']['lot-step']['value'], 2,
                           '.', ' ') : ''; ?>">
                <span class="form__error"><?= $data['fields']['lot-step']['validated'] ? '' : $data['fields']['lot-step']['error']; ?></span>

            </div>

            <div class="form__item <?= $data['fields']['lot-date']['validated'] ? '' : 'form__item--invalid'; ?>">

                <label for="lot-date">Дата завершения</label>
                <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="dd.mm.yyyy"
                       value="<?= $data['fields']['lot-date']['validated'] ? $data['fields']['lot-date']['value'] : ''; ?>">
                <span class="form__error"><?= $data['fields']['lot-date']['validated'] ? '' : $data['fields']['lot-date']['error']; ?></span>

            </div>

        </div>

        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button" name="submit">Добавить лот</button>

    </form>

</main>
