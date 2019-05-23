<?php foreach ($categories as $index): ?>
    <li class="promo__item promo__item--<?= $index['slug']; ?>">
        <a class="promo__link" href="pages/all-lots.html"><?= esc($index['name']); ?></a>
    </li>
<?php endforeach; ?>