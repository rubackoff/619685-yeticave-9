<?php
require_once('helpers.php');
$categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];
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
$title = 'Главная';

$content = include_template('index.php', [
        'categories' => $categories,
        'cats' => $cats
]);
$layout_content = include_template('layout.php', [
        'content' => $content,
        'user_name' => $user_name,
        'title' => $title,
        'categories' => $categories
]);

print($layout_content);
