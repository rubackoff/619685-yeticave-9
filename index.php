<?php
require_once('helpers.php');
$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];
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
        'price' => 5400,
        'img' => 'img/lot-6.jpg'
    ]
];
$title = 'Главная';
//Устанавливаем время по уомлчанию
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

// TS до полуночи следующего дня
$dt_end_lot = 'tomorrow';
$dt_end = date_create($dt_end_lot);
$dt_now = date_create("now");
$dt_diff = date_diff($dt_end, $dt_now);
$hours_count = date_interval_format($dt_diff, '%H:%I');
$less_than_hour_class = "";
if ($dt_diff->h <= 1) {
    $less_than_hour_class = "timer--finishing";
}

$content = include_template('index.php', [
    'categories' => $categories,
    'cats' => $cats,
    'hours_count' => $hours_count,
    'less_than_hour_class' => $less_than_hour_class
]);
$layout_content = include_template('layout.php', [
    'content' => $content,
    'user_name' => $user_name,
    'title' => $title,
    'categories' => $categories,
]);

print($layout_content);



