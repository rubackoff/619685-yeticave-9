<?php
require_once('helpers.php');

$page_content = include_template('index.php', [
        'categories' => $categories,
        'cats' => $cats
]);
$layout_content = include_template('layout.php', [
        'content' => $page_content,
        'user_name' => $user_name,
        'title' => $title
]);

print($layout_content);
