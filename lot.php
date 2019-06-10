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
SELECT l.name AS 'lot_name' , start_price, step_price, img, c.name AS 'categories_name', description, dt_over,dt_add, l.id AS 'lot_id' FROM Lot l
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

$accept = '';
$errors = [];
$form = [];


$id_bet = (int)$_GET['id'];


//Устанавливаем время по умолчанию
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');


//Таймер лота
$dt_end = date_create($lot['dt_over']);
$dt_now = date_create('now');
$dt_diff = date_diff($dt_end, $dt_now);
$total_hours = $dt_diff->days * 24 + $dt_diff->h;
$hours_count = date_interval_format($dt_diff, "$total_hours:%I");
$less_than_hour_class = "";
if ($total_hours <= 1) {
    $less_than_hour_class = "timer--finishing";
}

$sql = "SELECT MAX(price) AS 'bet'
FROM Bet
WHERE lot_id = $id_bet
";
$result = mysqli_query($con, $sql);
$last_bet = mysqli_fetch_assoc($result);
if (isset($last_bet)) {
    $current_price = (int)($last_bet['bet']) + (int)($lot['step_price']);
    $bet = $last_bet['bet'];
} else {
    $current_price = (int)($lot['start_price']) + (int)($lot['step_price']);
    $bet = $lot['start_price'];
}

if (!empty($_POST)) {
    if (!isset($_SESSION['user'])) {
        http_response_code(403);
        die();
    }
    $form = $_POST;
    $required_fields = ['price'];
    $errors = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }
    }
    if (isset($form['price'])) {
        if (!filter_var($form['price'], FILTER_VALIDATE_INT) || $form['price'] < $current_price) {
            $errors['price'] = 'Ставка должна быть целым числом, больше предыдущей ставки';
        }
    }
    if (empty($errors)) {
        $sql = 'INSERT INTO Bet (dt_add, price, lot_id, user_id) 
            VALUES (NOW(), ?, ?, ?)
            ';
        $stmt = db_get_prepare_stmt($con, $sql, [$form['price'], $id, $_SESSION['user']['id']]);
        $res = mysqli_stmt_execute($stmt);
        if ($res && empty($errors) ) {
            $accept = 'Ваша ставка добавлена';
            $current_price = (int)($form['price']) + (int)($lot['step_price']);
            $bet = $form['price'];
        }
    }
}



$content = include_template('lot.php', [
    'categories' => $categories,
    '$last_bet' => $last_bet,
    'lot' => $lot,
    'hours_count' => $hours_count,
    'less_than_hour_class' => $less_than_hour_class,
    'current_price' => $current_price,
    'bet' => $bet,
    'last_bet' => $last_bet,
    'id_bet' => $id_bet,
    'form' => $form,
    'errors' => $errors,
    'accept' => $accept
]);


$layout_content = include_template('layout.php', [
    'content' => $content,
    'categories' => $categories,
    'title' => $title
]);
print($layout_content);