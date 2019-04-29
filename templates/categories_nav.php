<?php
    $categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];
    ?>
<?php foreach($categories as $index): ?>
    <li class="promo__item promo__item--boards">
        <a class="promo__link" href="pages/all-lots.html"><?=esc($index); ?></a>
    </li>
<?php endforeach; ?>