<!DOCTYPE html>
<html lang="ru">
    <main class="container">
        <section class="promo">
            <h2 class="promo__title">Нужен стафф для катки?</h2>
            <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
            <ul class="promo__list">
                <?php
                function esc($str) {
                $text = htmlspecialchars($str);
                //$text = strip_tags($str);

                return $text;
                }
                ?>
                <?php
                $categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];
                ?>
                <?php
                require ('templates/categories_nav.php');
                ?>
            </ul>
        </section>
        <section class="lots">
            <div class="lots__header">
                <h2>Открытые лоты</h2>
            </div>
            <ul class="lots__list">
                <?php
                $cats = [
                    [
                        'name' => '2014 Rossignol District Snowboard',
                        'categories' => 'Доски и лыжи',
                        'price' => 10999,
                        'img' => 'img/lot-1.jpg'
                    ],
                    [
                        'name' => 'DC Ply Mens 2016/2017 Snowboard',
                        'categories' => 'Доски и лыжи',
                        'price' => 159999,
                        'img' => 'img/lot-2.jpg'
                    ],
                    [
                        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
                        'categories' => 'Крепления',
                        'price' => 8000,
                        'img' => 'img/lot-3.jpg'
                    ],
                    [
                        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
                        'categories' => 'Ботинки',
                        'price' => 10999,
                        'img' => 'img/lot-4.jpg'
                    ],
                    [
                        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
                        'categories' => 'Одежда',
                        'price' => 7500,
                        'img' => 'img/lot-5.jpg'
                    ],
                    [
                        'name' => 'Маска Oakley Canopy',
                        'categories' => 'Разное',
                        'price' => 	5400,
                        'img' => 'img/lot-6.jpg'
                    ]
                ];
                ?>
                <?php
                function formatting_price($price)
                {
                    $price = ceil($price);
                    if ($price >= 1000) {
                        $price = number_format ($price, 0 , ".", " ");
                    }
                    return $price .= " ₽";
                }
                ?>
                <?php foreach ($cats as $key => $item): ?>
                    <li class="lots__item lot">
                        <div class="lot__image">
                            <img src="<?=$item['img']; ?>" width="350" height="260" alt="">
                        </div>
                        <div class="lot__info">
                            <span class="lot__category"><?=esc($item['categories']); ?></span>
                            <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?=esc($item['name']); ?></a></h3>
                            <div class="lot__state">
                                <div class="lot__rate">
                                    <span class="lot__amount">Стартовая цена</span>
                                    <span class="lot__cost"><?=formatting_price($item['price']); ?><b class="rub">р</b></span>
                                </div>
                                <div class="lot__timer timer">
                                    12:23
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
</html>
