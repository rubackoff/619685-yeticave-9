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
    <section class="lot-item container">
        <h2><?= esc($lot['lot_name']); ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="uploads/<?= $lot['img']; ?>" width="730" height="548"
                         alt="<?= $lot['categories_name']; ?>">
                </div>
                <p class="lot-item__category">Категория: <span><?=$lot['categories_name']; ?></span></p>
                <p class="lot-item__description">
                    <?= esc($lot['description']); ?>
                </p>
            </div>
            <div class="lot-item__right">

                <div class="lot-item__state">
                    <div class="lot-item__timer timer <?= $less_than_hour_class; ?>">
                        <?= $hours_count; ?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?= $bet; ?> р</span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?= $current_price; ?> р</span>
                        </div>
                    </div>
                    <?php $invalid = count($errors) ? "form--invalid" : ""; ?>
                    <?php if (isset($_SESSION['user'])): ?>
                    <form class="lot-item__form <?= $invalid; ?>" action="" method="post" autocomplete="off">
                        <?php
                        $classname = isset($errors['price']) ? "form__item--invalid" : "";
                        $value = isset($form['price']) ? $form['price'] : "";
                        ?>
                        <p class="lot-item__form-item form__item <?= $classname; ?>">
                            <label for="price">Ваша ставка</label>
                            <input id="price" type="text" name="price" placeholder="<?= $current_price ?>" value="<?= $value; ?>">
                            <span class="form__error"><?= $errors['price']; ?></span>
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>