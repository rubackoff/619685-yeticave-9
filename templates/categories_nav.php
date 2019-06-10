<?php foreach ($categories as $index): ?>
    <li class="nav__item">
        <a href="pages/all-lots.html"><?= esc($index['name']); ?></a>
    </li>
<?php endforeach; ?>