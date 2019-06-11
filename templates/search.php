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
        <div class="container">
            <section class="lots">
                <h2>Результаты поиска по запросу «<?= $search; ?>»</h2>
                <?php foreach ($lot as $item): ?>
                <ul class="lots__list">
                    <li class="lots__item lot">
                        <div class="lot__image">
                            <img src="uploads/<?= $item['img']; ?>" width="350" height="260" alt="Сноуборд">
                        </div>
                        <div class="lot__info">
                            <span class="lot__category"><?= esc($item['categories_name']); ?></span>
                            <h3 class="lot__title"><a class="text-link" href="<?= $item['url']; ?>"><?= esc($item['lot_name']); ?></a></h3>
                            <div class="lot__state">
                                <div class="lot__rate">
                                    <span class="lot__amount">Стартовая цена</span>
                                    <span class="lot__cost"><?= formatting_price($item['start_price']); ?></span>
                                </div>
                                <div class="lot__timer timer <?= $less_than_hour_class; ?>">
                                    <?= $item['over_time'] ?>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </section>
            <?php endforeach; ?>
            <ul class="pagination-list">
                <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
                <?php if ($pages_count > 1): ?>
                            <?php foreach ($pages as $page): ?>
                                <li class="pagination__item <?php if ($page == $cur_page): ?>pagination__item--active<?php endif; ?>">
                                    <a href="/?page=<?=$page;?>"><?=$page;?></a>
                                </li>
                            <?php endforeach; ?>
                <?php endif; ?>
                <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
            </ul>
        </div>
    </main>