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
    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">
    <?php foreach ($lot as $item): ?>
                <tr class="rates__item rates__item--">
                    <td class="rates__info">
                        <div class="rates__img">
                            <img src="/uploads/<?= $item['img']; ?>" width="54" height="40" alt="<?= $item['lot_name']; ?>">
                        </div>
                        <div>
                            <h3 class="rates__title"><a href="<?= $item['url']; ?>"><?= $item['lot_name']; ?></a></h3>
                            <p><?= $item['message']; ?></p>
                        </div>
                    </td>
                    <td class="rates__category">
                        <?= $item['categories_name']; ?>
                    </td>
                    <td class="rates__timer">
                        <div class="timer <?= $less_than_hour_class; ?>"><?= $item['over_time']; ?></div>
                    </td>
                    <td class="rates__price">
                        <?= $item['price']; ?>
                    </td>
                    <td class="rates__time">
                        <?= $item['dt_add']; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr class="rates__item rates__item--win">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="../img/rate3.jpg" width="54" height="40" alt="Крепления">
                    </div>
                    <div>
                        <h3 class="rates__title"><a href="lot.html">Крепления Union Contact Pro 2015 года размер L/XL</a></h3>
                        <p>Телефон +7 900 667-84-48, Скайп: Vlas92. Звонить с 14 до 20</p>
                    </div>
                </td>
                <td class="rates__category">
                    Крепления
                </td>
                <td class="rates__timer">
                    <div class="timer timer--win">Ставка выиграла</div>
                </td>
                <td class="rates__price">
                    10 999 р
                </td>
                <td class="rates__time">
                    Час назад
                </td>
            </tr>
        </table>
    </section>
</main>
