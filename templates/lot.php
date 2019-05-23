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
                    <img src="<?= $lot['img']; ?>" width="730" height="548" alt="<?= esc($lot['categories_name']); ?>">
                </div>
                <p class="lot-item__category">Категория: <span><?= esc($lot['categories_name']); ?></span></p>
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
                            <span class="lot-item__cost">10 999</span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span>12 000 р</span>
                        </div>
                    </div>
                    <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post" autocomplete="off">
                        <p class="lot-item__form-item form__item form__item--invalid">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost" placeholder="12 000">
                            <span class="form__error">Введите наименование лота</span>
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                </div>

            </div>
        </div>
    </section>
</main>