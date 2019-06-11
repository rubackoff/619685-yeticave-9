<?php
require_once('helpers.php');

session_start();

$con = mysqli_connect("localhost", "root", "", "yeticave");

mysqli_set_charset($con, "utf8");

/*Запрос на название и спец. ключ категорий */
$sql = 'SELECT name, slug FROM Categories';
$result = mysqli_query($con, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

$lot = [];

mysqli_query($con, "CREATE FULLTEXT INDEX lot_ft_search ON lot(name, description)");

$search = $_GET['q'] ?? '';
$cur_page = $_GET['page'] ?? 1;
$page_items = 9;
$result = mysqli_query($con, "SELECT COUNT(*) as cnt FROM lot");
$items_count = mysqli_fetch_assoc($result)['cnt'];

$pages_count = ceil($items_count / $page_items);
$offset = ($cur_page - 1) * $page_items;

$pages = range(1, $pages_count);

if ($search) {
    $sql = "
    SELECT l.name AS 'lot_name' , start_price, step_price, img, c.name AS 'categories_name', description, dt_over,dt_add, l.id AS 'lot_id' FROM Lot l
    JOIN Categories c ON l.categories_id = c.id
    WHERE MATCH(title, description) AGAINST(?)";
    $stmt = db_get_prepare_stmt($con, $sql, [$search]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
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

//Таймер лота
    foreach ($lot AS $key => $lots) {
        $dt_end = date_create($lots['dt_over']);
        $dt_now = date_create('now');
        $dt_diff = date_diff($dt_end, $dt_now);
        $total_hours = $dt_diff->days * 24 + $dt_diff->h;
        $hours_count = date_interval_format($dt_diff, "$total_hours:%I");
        $less_than_hour_class = "";
        if ($total_hours <= 1) {
            $less_than_hour_class = "timer--finishing";
        }
        $lot[$key]['over_time'] = $hours_count;
    }
}

//Подключаем шаблоны
$content = include_template('search.php', [
    'categories' => $categories,
    'lot' => $lot,
    'hours_count' => $hours_count,
    'less_than_hour_class' => $less_than_hour_class,
    'pages' => $pages,
    'pages_count' => $pages_count,
    'cur_page' => $cur_page,
    'url' => $url
]);
$layout_content = include_template('layout.php', [
    'content' => $content,
    'title' => $title,
    'categories' => $categories,
]);

print($layout_content);