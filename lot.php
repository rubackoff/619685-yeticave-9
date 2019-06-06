<?php
require_once('helpers.php');
session_start();

$con = mysqli_connect("localhost", "root", "", "yeticave");

mysqli_set_charset($con, "utf8");

/*Запрос на название и спец. ключ категорий */
$sql = "SELECT name, slug FROM Categories";
$result = mysqli_query($con, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);


/*
 * Запрос на название лота, стартовую цену, ссылку на изображение,
 * название категории.
 *
 */
$id = 0;
$is_404 = true;
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "
SELECT l.name AS 'lot_name' , start_price, step_price, img, c.name AS 'categories_name', description, dt_over, l.id AS 'lot_id' FROM Lot l
JOIN Categories c ON l.categories_id = c.id
WHERE l.id = $id
";
    $result = mysqli_query($con, $sql);
    $lot = mysqli_fetch_assoc($result);
    if ($lot) {
        $is_404 = false;
        $title = $lot["lot_name"];
    }
}

if ($is_404) {
    http_response_code(404);
    die();
}

$current_price = (int)($lot['start_price']) + (int)($lot['step_price']);

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

$content = include_template('lot.php', [
    'categories' => $categories,
    'lot' => $lot,
    'hours_count' => $hours_count,
    'less_than_hour_class' => $less_than_hour_class,
    'current_price' => $current_price
]);
$layout_content = include_template('layout.php', [
    'content' => $content,
    'user_name' => $user_name,
    'categories' => $categories,
    'title' => $title
]);
print($layout_content);