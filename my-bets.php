<?php
require_once('helpers.php');
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: /sign-up.php");
    exit();
}

$con = mysqli_connect("localhost", "root", "", "yeticave");

mysqli_set_charset($con, "utf8");

/*Запрос на название и спец. ключ категорий */
$sql = "SELECT name, slug FROM Categories";
$result = mysqli_query($con, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

$title = 'Мои ставки';

if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['id'];
}

$sql = "SELECT l.name AS 'lot_name', price, l.img AS 'img', c.name AS 'categories_name', b.dt_add AS 'dt_add', dt_over, u.message AS 'message', l.id AS 'lot_id', u.id AS 'user_id' FROM Bet b
JOIN User u ON b.user_id = u.id
JOIN Lot l ON b.lot_id = l.id
JOIN Categories c ON l.categories_id = c.id
WHERE u.id = $user_id
";
$result = mysqli_query($con, $sql);
$lot = mysqli_fetch_all($result, MYSQLI_ASSOC);


foreach ($lot as $key => $lots) {
    $params = [
        'id' => $lots['lot_id']
    ];
    $scriptname = pathinfo('lot.php', PATHINFO_BASENAME);
    $query = http_build_query($params);
    $url = "/" . $scriptname . "?" . $query;
    $lot[$key]['url'] = $url;
}
foreach ($lot AS $key => $lots) {
    $dt_end = date_create($lots['dt_over']);
    $dt_now = date_create('now');
    $dt_diff = date_diff($dt_end, $dt_now);
    $total_hours = $dt_diff->days * 24 + $dt_diff->h;
    $hours_count = date_interval_format($dt_diff, "$total_hours:%I");
    $less_than_hour_class = "";
    if ($total_hours <= 1) {
        $less_than_hour_class = "timer--finishing";
    } else if($total_hours = 0) {
        $less_than_hour_class = 'timer--end';
    }
    $lot[$key]['over_time'] = $hours_count;
}


$content = include_template('my-bets.php', [
    'categories' => $categories,
    '$last_bet' => $last_bet,
    'lot' => $lot,
    'url' => $url,
    'hours_count' => $hours_count,
    'less_than_hour_class' => $less_than_hour_class
]);

$layout_content = include_template('layout.php', [
    'content' => $content,
    'categories' => $categories,
    'title' => $title
]);
print($layout_content);