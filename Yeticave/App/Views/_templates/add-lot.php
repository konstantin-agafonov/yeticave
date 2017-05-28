<main>

    <?= includeTemplate('../Yeticave/App/Views/_templates/header-nav.php',[
        'categories' => $data['categories']
    ]); ?>

    <form class="form form--add-lot container <?= $data['form_validated'] ? '' : ' form--invalid'; ?>"
          method="post" enctype="multipart/form-data"> <!-- form--invalid -->

        <h2>Добавление лота</h2>

        <div class="form__container-two">

            <div class="form__item <?=isset($data['fields']['lot-name']['errors']) ? 'form__item--invalid' : ''; ?>">
                <!-- form__item--invalid -->

                <label for="lot-name">Наименование</label>
                <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота"
                       value="<?= $data['fields']['lot-name']['value'] ? $data['fields']['lot-name']['value'] : ''; ?>">

                <?php
                if (isset($data['fields']['lot-name']['errors'])) {
                    foreach ($data['fields']['lot-name']['errors'] as $error) { ?>

                        <span class="form__error">
                            <?=$error;?>
                        </span>

                    <?php }
                } ?>

            </div>

            <?php
            $entered_category = isset($data['fields']['category']['value']) ? $data['fields']['category']['value'] : null;
            ?>

            <div class="form__item <?=(isset($data['fields']['category']['errors'])
                    || (!$entered_category && !$data['form_validated'])) ? 'form__item--invalid' : ''; ?>">

                <label for="category">Категория</label>

                <select id="category" name="category">

                    <option value="" <?= ($entered_category) ? '' : 'selected'; ?> disabled>Выберите категорию
                    </option>

                    <?php foreach ($data['categories'] as $category): ?>
                        <option value="<?= $category['id']; ?>"
                            <?= ((int)$entered_category === $category['id']) ? ' selected' : ''; ?>>
                            <?= htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>

                </select>

                <?php
                if (!$entered_category && !$data['form_validated']) { ?>
                    <span class="form__error">
                            Необходимо выбрать категорию!
                    </span>
                <?php } else {
                        if (isset($data['fields']['category']['errors'])) {
                            foreach ($data['fields']['category']['errors'] as $error) { ?>

                               <span class="form__error">
                                  <?=$error;?>
                               </span>

                        <?php }
                            }
                        }?>

            </div>

        </div>

        <div class="form__item form__item--wide <?=isset($data['fields']['message']['errors']) ? 'form__item--invalid' : ''; ?>">

            <label for="message">Описание</label>
            <textarea id="message" name="message"
                      placeholder="Напишите описание лота"><?= $data['fields']['message']['value'] ? $data['fields']['message']['value'] : ''; ?></textarea>

            <?php
            if (isset($data['fields']['message']['errors'])) {
                foreach ($data['fields']['message']['errors'] as $error) { ?>

                    <span class="form__error">
                            <?=$error;?>
                        </span>

                <?php }
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

        <span style="color:red;"><?= (isset($data['file']['error'])) ? $data['file']['error'] : ''; ?></span>

        <div class="form__container-three">

            <div class="form__item form__item--small <?=isset($data['fields']['lot-rate']['errors']) ? 'form__item--invalid' : ''; ?>">

                <label for="lot-rate">Начальная цена</label>
                <input id="lot-rate" type="number" name="lot-rate" placeholder="0" min="0" step="0.01"
                       value="<?= $data['fields']['lot-rate']['value'] ? number_format($data['fields']['lot-rate']['value'], 2,
                           '.', ' ') : ''; ?>">

                <?php
                if (isset($data['fields']['lot-rate']['errors'])) {
                    foreach ($data['fields']['lot-rate']['errors'] as $error) { ?>

                        <span class="form__error">
                            <?=$error;?>
                        </span>

                    <?php }
                } ?>

            </div>

            <div class="form__item form__item--small <?=isset($data['fields']['lot-step']['errors']) ? 'form__item--invalid' : ''; ?>">

                <label for="lot-step">Шаг ставки</label>
                <input id="lot-step" type="number" name="lot-step" placeholder="0" min="0" step="0.01"
                       value="<?= $data['fields']['lot-step']['value'] ? number_format($data['fields']['lot-step']['value'], 2,
                           '.', ' ') : ''; ?>">

                <?php
                if (isset($data['fields']['lot-step']['errors'])) {
                    foreach ($data['fields']['lot-step']['errors'] as $error) { ?>

                        <span class="form__error">
                            <?=$error;?>
                        </span>

                    <?php }
                } ?>

            </div>

            <div class="form__item <?=isset($data['fields']['lot-date']['errors']) ? 'form__item--invalid' : ''; ?>">

                <label for="lot-date">Дата завершения</label>
                <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="dd.mm.yyyy"
                       value="<?= $data['fields']['lot-date']['value'] ? $data['fields']['lot-date']['value'] : ''; ?>">

                <?php
                if (isset($data['fields']['lot-date']['errors'])) {
                    foreach ($data['fields']['lot-date']['errors'] as $error) { ?>

                        <span class="form__error">
                            <?=$error;?>
                        </span>

                    <?php }
                } ?>

            </div>

        </div>

        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button" name="submit">Добавить лот</button>

    </form>

</main>
