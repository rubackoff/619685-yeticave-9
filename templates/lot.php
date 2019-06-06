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
                <?php if (isset($_SESSION['user'])): ?>
                <div class="lot-item__state">
                    <div class="lot-item__timer timer <?= $less_than_hour_class; ?>">
                        <?= $hours_count; ?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?= $lot['start_price']; ?> р</span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?= $current_price; ?> р</span>
                        </div>
                    </div>
                    <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post" autocomplete="off">
                        <p class="lot-item__form-item form__item form__item--invalid">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost" placeholder="<?= $current_price ?>">
                            <span class="form__error">Введите наименование лота</span>
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>