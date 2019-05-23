<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное
            снаряжение.</p>
        <ul class="promo__list">
            <?php
            echo include_template('categories_nav.php', [
                'categories' => $categories,
            ]);
            ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <?php foreach ($lots as $item): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= $item['img']; ?>" width="350" height="260" alt="">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= esc($item['categories_name']); ?></span>
                        <h3 class="lot__title"><a class="text-link" href="<?= $item['url']; ?>"><?= esc($item['lot_name']); ?></a>
                        </h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount">Стартовая цена</span>
                                <span class="lot__cost"><?= formatting_price($item['start_price']); ?></span>
                            </div>
                            <div class="lot__timer timer <?= $less_than_hour_class; ?>">
                                <?= $hours_count; ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</main>
