<?php
require_once('helpers.php');

session_start();

$con = mysqli_connect("localhost", "root", "", "yeticave");

mysqli_set_charset($con, "utf8");

 //Проверка соединения с БД
/*if ($con == false) {
    print("Ошибка подключения: " . mysqli_connect_error());
} else {
    print("Соединение установлено");
}*/


$title = 'Главная';

/*Запрос на название и спец. ключ категорий */
$sql = 'SELECT name, slug FROM Categories';
$result = mysqli_query($con, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);



/*
 * Запрос на название лота, стартовую цену, ссылку на изображение,
 * название категории.
 *
 */
$sql = "
SELECT l.name AS 'lot_name' , start_price, img, c.name, description, c.name AS 'categories_name', l.id AS 'lot_id', dt_over FROM lot l
JOIN Categories c ON l.categories_id = c.id
ORDER BY l.dt_add DESC
";
$result = mysqli_query($con, $sql);
$lots = mysqli_fetch_all($result, MYSQLI_ASSOC);


/*
 * Создали массив с массивами из списка лотов.
 * В массивы добавили ключи url с ссылкой и запросом на лот по id.
 */
foreach ($lots as $key => $lot) {
    $params = [
        'id' => $lot['lot_id']
    ];
    $scriptname = pathinfo('lot.php', PATHINFO_BASENAME);
    $query = http_build_query($params);
    $url = "/" . $scriptname . "?" . $query;
    $lots[$key]['url'] = $url;
}


//Устанавливаем время по умолчанию
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

//Таймер лота
foreach ($lots AS $key => $lot){
    $dt_end = date_create($lot['dt_over']);
    $dt_now = date_create('now');
    $dt_diff = date_diff($dt_end, $dt_now);
    $total_hours = $dt_diff->days * 24 + $dt_diff->h;
    $hours_count = date_interval_format($dt_diff, "$total_hours:%I");
    $less_than_hour_class = "";
    if ($total_hours <= 1) {
        $less_than_hour_class = "timer--finishing";
    }
    $lots[$key]['over_time'] = $hours_count;
}



//Подключаем шаблоны
$content = include_template('index.php', [
    'categories' => $categories,
    'lots' => $lots,
    'hours_count' => $hours_count,
    'less_than_hour_class' => $less_than_hour_class,
    'url' => $url
]);
$layout_content = include_template('layout.php', [
    'content' => $content,
    'title' => $title,
    'categories' => $categories
]);

print($layout_content);

