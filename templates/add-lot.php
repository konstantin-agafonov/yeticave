<?php

global $categories;

$form_validated = true;

$fields = [
    "lot-name" => [
        'value' => null,
        'filter' => FILTER_SANITIZE_STRING,
        'filter_options' => null,
        'validated' => true,
        'error' => null
    ],
    "category" => [
        'value' => null,
        'filter' => FILTER_VALIDATE_INT,
        'filter_options' => null,
        'validated' => true,
        'error' => null
    ],
    "message" => [
        'value' => null,
        'filter' => FILTER_SANITIZE_STRING,
        'filter_options' => null,
        'validated' => true,
        'error' => null
    ],
    "lot-rate" => [
        'value' => null,
        'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
        'filter_options' => [
            'flags' => FILTER_FLAG_ALLOW_FRACTION
        ],
        'validated' => true,
        'error' => null
    ],
    "lot-step" => [
        'value' => null,
        'filter' => FILTER_SANITIZE_NUMBER_FLOAT,
        'filter_options' => [
            'flags' => FILTER_FLAG_ALLOW_FRACTION
        ],
        'validated' => true,
        'error' => null
    ],
    "lot-date" => [
        'value' => null,
        'filter' => FILTER_SANITIZE_STRING,
        'filter_options' => null,
        'validated' => true,
        'error' => null
    ],
];

if ($_POST) {

    foreach ($fields as $field_name => &$field) {
        if (!isset($_POST[$field_name]) || $_POST[$field_name] == '') {
            $field['error'] = 'Поле должно быть заполнено';
            $field['validated'] = false;
            continue;
        } else {
            $field['value'] = trim($_POST[$field_name]);
        }
        $field['value'] = filter_var(
            $field['value'],
            $field['filter'] ? $field['filter'] : FILTER_DEFAULT,
            $field['filter_options']
        );
        if ($field['value'] === false || $field['value'] == '') {
            $field['error'] = 'Введено некорректное значение';
            $field['validated'] = false;
        }
    }
    unset($field);

    if ($fields['lot-rate']['validated']) {
        if ($fields['lot-rate']['value'] == 0.00 ) {
            $fields['lot-rate']['validated'] = false;
            $fields['lot-rate']['error'] = 'Поле должно быть заполнено';
        }
    }
    if ($fields['lot-step']['validated']) {
        if ($fields['lot-step']['value'] == 0.00 ) {
            $fields['lot-step']['validated'] = false;
            $fields['lot-step']['error'] = 'Поле должно быть заполнено';
        }
    }

    if ($fields['lot-date']['validated']) {
        $test_date = explode('.', $fields['lot-date']['value']);
        if (!checkdate($test_date[1], $test_date[0], $test_date[2])) {
            $fields['lot-date']['validated'] = false;
            $fields['lot-date']['error'] = 'Введено некорректное значение';
        }
    }

    if (isset($_FILES['photo']) && !$_FILES['photo']['error']) {
        if (in_array($_FILES['photo']['type'],['image/jpeg','image/png'])) {
            $file['name'] = basename($_FILES['photo']['name']);
            $file['path'] = $_SERVER["DOCUMENT_ROOT"] . '\uploads\\' . $file['name'];
            if (!move_uploaded_file($_FILES['photo']['tmp_name'],$file['path'])) {
                $file['error'] = 'Картинка не загружена';
                $form_validated = false;
            }
        } else {
            $file['error'] = 'Картинка должна быть в формате jpeg или png';
            $form_validated = false;
        }
    } else {
        $file['error'] = 'Картинка должна быть загружена';
        $form_validated = false;
    }

    if ($form_validated) {
        foreach ($fields as &$field) {
            if (!$field['validated']) {
                $form_validated = false;
                break;
            }
        }
        unset($field);
    }

}

if ($_POST && $form_validated):

echo includeTemplate('templates/lots.php',[
    'bets' => [],
    'lot' => [
        'name' => $fields['lot-name']['value'],
        'category' => $fields['category']['value'],
        'price' => $fields['lot-rate']['value'],
        'pic' => '../uploads/' . $file['name'],
        'description' => $fields['message']['value'],
        'step' => $fields['lot-step']['value'],
    ],
    'category' => $categories[ $fields['category']['value'] ]
]);

else: ?>

    <main>

        <?php headerNav(); ?>

        <form class="form form--add-lot container <?= $form_validated ? '' : ' form--invalid'; ?>" action="add.php"
              method="post" enctype="multipart/form-data"> <!-- form--invalid -->

            <h2>Добавление лота</h2>

            <div class="form__container-two">

                <div class="form__item <?= $fields['lot-name']['validated'] ? '' : 'form__item--invalid'; ?>">
                    <!-- form__item--invalid -->

                    <label for="lot-name">Наименование</label>
                    <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота"
                           value="<?= $fields['lot-name']['validated'] ? $fields['lot-name']['value'] : ''; ?>">
                    <span class="form__error"><?= $fields['lot-name']['validated'] ? '' : $fields['lot-name']['error']; ?></span>

                </div>

                <div class="form__item <?= $fields['category']['validated'] ? '' : 'form__item--invalid'; ?>">

                    <label for="category">Категория</label>

                    <?php
                    $entered_category = $fields['category']['validated'] ? $fields['category']['value'] : null;
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
                    <span class="form__error"><?= $fields['category']['validated'] ? '' : $fields['category']['error']; ?></span>

                </div>

            </div>

            <div class="form__item form__item--wide <?= $fields['message']['validated'] ? '' : 'form__item--invalid'; ?>">

                <label for="message">Описание</label>
                <textarea id="message" name="message"
                          placeholder="Напишите описание лота"><?= $fields['message']['validated'] ? $fields['message']['value'] : ''; ?></textarea>
                <span class="form__error"><?= $fields['message']['validated'] ? '' : $fields['message']['error']; ?></span>

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

            <span style="color:red;"><?=(isset($file['error']))?$file['error']:'';?></span>

            <div class="form__container-three">

                <div class="form__item form__item--small <?= $fields['lot-rate']['validated'] ? '' : 'form__item--invalid'; ?>">

                    <label for="lot-rate">Начальная цена</label>
                    <input id="lot-rate" type="number" name="lot-rate" placeholder="0" min="0" step="0.01"
                           value="<?= $fields['lot-rate']['validated'] ? number_format($fields['lot-rate']['value'], 2,
                               '.', ' ') : ''; ?>">
                    <span class="form__error"><?= $fields['lot-rate']['validated'] ? '' : $fields['lot-rate']['error']; ?></span>

                </div>

                <div class="form__item form__item--small <?= $fields['lot-step']['validated'] ? '' : 'form__item--invalid'; ?>">

                    <label for="lot-step">Шаг ставки</label>
                    <input id="lot-step" type="number" name="lot-step" placeholder="0" min="0" step="0.01"
                           value="<?= $fields['lot-step']['validated'] ? number_format($fields['lot-step']['value'], 2,
                               '.', ' ') : ''; ?>">
                    <span class="form__error"><?= $fields['lot-step']['validated'] ? '' : $fields['lot-step']['error']; ?></span>

                </div>

                <div class="form__item <?= $fields['lot-date']['validated'] ? '' : 'form__item--invalid'; ?>">

                    <label for="lot-date">Дата завершения</label>
                    <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="dd.mm.yyyy"
                           value="<?= $fields['lot-date']['validated'] ? $fields['lot-date']['value'] : ''; ?>">
                    <span class="form__error"><?= $fields['lot-date']['validated'] ? '' : $fields['lot-date']['error']; ?></span>

                </div>

            </div>

            <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
            <button type="submit" class="button" name="submit">Добавить лот</button>

        </form>

    </main>

<?php endif; ?>
