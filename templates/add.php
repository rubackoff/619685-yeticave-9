 <main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php
            echo include_template('categories_nav.php', [
                'categories' => $categories,
            ]);
            ?>
        </ul>
    </nav>
    <?php $invalid = count($errors) ? "form--invalid" : ""; ?>
    <form class="form form--add-lot container <?= $invalid; ?>" enctype="multipart/form-data" action="add.php"
          method="post">
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <?php
            $classname = isset($errors['name']) ? "form__item--invalid" : "";
            $value = isset($lot['name']) ? $lot['name'] : "";
            ?>
            <div class="form__item <?= $classname; ?>">
                <label for="lot_name">Наименование <sup>*</sup></label>
                <input id="lot_name" type="text" name="name" value="<?= $value; ?>">
                <span class="form__error">Введите наименование лота</span>
            </div>
            <?php
            $classname = isset($errors['category']) ? "form__item--invalid" : "";
            $value = isset($lot['category']) ? $lot['category'] : "";
            ?>
            <div class="form__item <?= $classname; ?>">
                <label for="category">Категория <sup>*</sup></label>
                <select id="category" name="category">
                    <option value="">Выберите категорию</option>
                    <?php foreach ($categories as $index): ?>
                        <option <?php if ($value == $index['id']) {
                            echo 'selected';
                        } ?> value="<?= $index['id']; ?>"><?= esc($index['name']); ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="form__error">Выберите категорию</span>
            </div>
        </div>
        <?php
        $classname = isset($errors['description']) ? "form__item--invalid" : "";
        $value = isset($lot['description']) ? $lot['description'] : "";
        ?>
        <div class="form__item form__item--wide <?= $classname; ?>">
            <label for="description">Описание <sup>*</sup></label>
            <textarea id="description" name="description"><?= $value; ?></textarea>
            <span class="form__error">Напишите описание лота</span>
        </div>
        <?php
        $classname = isset($errors['img']) ? "form__item--invalid" : "";
        $value = isset($lot['img']) ? $lot['img'] : "";
        ?>
        <div class="form__item form__item--file <?= $classname; ?>">
            <label>Изображение <sup>*</sup></label>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="img" name="img" value="">
                <label for="img">
                    Добавить
                </label>
                <span class="form__error"><?= $errors['img']; ?></span>
            </div>
        </div>
        <div class="form__container-three">
            <?php
            $classname = isset($errors['start_price']) ? "form__item--invalid" : "";
            $value = isset($lot['start_price']) ? $lot['start_price'] : "";
            ?>
            <div class="form__item form__item--small <?= $classname; ?>">
                <label for="start_price">Начальная цена <sup>*</sup></label>
                <input id="start_price" type="text" name="start_price" value="<?= $value; ?>">
                <span class="form__error"><?= $errors['start_price']; ?></span>
            </div>
            <?php
            $classname = isset($errors['step_price']) ? "form__item--invalid" : "";
            $value = isset($lot['step_price']) ? $lot['step_price'] : "";
            ?>
            <div class="form__item form__item--small <?= $classname; ?>">
                <label for="step_price">Шаг ставки <sup>*</sup></label>
                <input id="step_price" type="text" name="step_price" value="<?= $value; ?>">
                <span class="form__error"><?= $errors['step_price']; ?></span>
            </div>
            <?php
            $classname = isset($errors['dt_over']) ? "form__item--invalid" : "";
            $value = isset($lot['dt_over']) ? $lot['dt_over'] : "";
            ?>
            <div class="form__item <?= $classname; ?>">
                <label for="dt_over">Дата окончания торгов <sup>*</sup></label>
                <input class="form__input-date" id="dt_over" type="text" name="dt_over"
                       value="<?= $value; ?>">
                <span class="form__error"><?= $errors['dt_over']; ?></span>
            </div>
        </div>
        <?php if (isset($errors)): ?>
            <div class="form__errors">
                <p>Пожалуйста, исправьте следующие ошибки:</p>
                <ul>
                    <?php foreach ($errors as $err => $val): ?>
                        <li><strong><?= $dict[$err]; ?>: </strong><?= $val; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>