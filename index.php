<?php
require_once('helpers.php');

$con = mysqli_connect("localhost", "root", "","yeticave");

mysqli_set_charset($con, "utf8");

/* Проверка соединения с БД
if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
} else {
    print("Соединение установлено");
}
*/

/*Запрос на название и спец. ключ Категорий */
$sql = "SELECT name, slug FROM Categories";
$result = mysqli_query($con, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

/*
 * Запрос на название лота, стартовую цену, ссылку на изображение,
 * название категории.
 *
 */
$sql ='
SELECT l.name AS "lot_name" , start_price, img, c.name AS "categories_name" FROM Lot l
JOIN Categories c ON l.categories_id = c.id
WHERE l.dt_over IS NULL
ORDER BY l.dt_add DESC
';
$result = mysqli_query($con, $sql);
$cats = mysqli_fetch_all($result, MYSQLI_ASSOC);


$title = 'Главная';

//Устанавливаем время по умолчанию
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

