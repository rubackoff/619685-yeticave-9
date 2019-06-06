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
$sql = "SELECT name, slug, id FROM Categories";
$result = mysqli_query($con, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

$content = include_template('add.php', [
    'categories' => $categories,
]);

/**
 * Проверяем была ли отправлена форма
 * Проверяем метод, которым запрщена страница
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lot = $_POST;

    /* Начинаем валидацию формы */

    /*Определяем обязательные поля*/
    $required_fields = ['name', 'category', 'description', 'start_price', 'step_price', 'dt_over'];
    $dict = ['name' => 'Название', 'category' => 'Категория', 'description' => 'Описание', 'start_price' => 'Начальная цена',
        'step_price' => 'Шаг ставки', 'dt_over' => 'Дата окончания', 'img' => 'Изображение'];
    $errors = [];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }
    }

    foreach ($_POST as $key => $value) {
        if ($key == 'step_price') {
            if (!filter_var($value, FILTER_VALIDATE_INT) > 0) {
                $errors[$key] = 'Шаг должен быть целым числом, больше нуля';
            }
        } elseif ($key == 'start_price') {
            if (!filter_var($value, FILTER_VALIDATE_INT) > 0) {
                $errors[$key] = 'Начальная цена должна быть больше нуля';
            }
        } elseif ($key == 'dt_over') {
            if (!is_date_valid($key)) {
                $dt_end_lot = $value;
                if (DateTime::createFromFormat('Y-m-d', $value) == false) {
                    $errors[$key] = 'Дата должна быть формата «ГГГГ-ММ-ДД»';
                } else {
                    $dt_end = date_create($dt_end_lot);
                    $dt_now = date_create('now');
                    $dt_diff = date_diff($dt_now, $dt_end);
                    $days_count = date_interval_format($dt_diff, '%a');
                    if ($dt_diff->invert == 1) {
                        $days_count = $days_count * -1;
                    }
                    if ($days_count < 1) {
                        $errors[$key] = 'Не может быть дата завершения меньше, чем сутки';
                    }
                }
            }
        }
    }

    /*Проверяем формат изображения Лота*/

    if (isset($_FILES['img']['name']) and $_FILES['img']['name'] !== '') {
        if (count($errors) == 0) {
            $tmp_name = $_FILES['img']['tmp_name'];
            $path = $_FILES['img']['name'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $tmp_name);
            if ($file_type !== 'image/jpeg' || $file_type !== 'image/png') {
                $errors['img'] = 'Загрузите картинку в формате JPEG или PNG';
            } else {
                if ($file_type == 'image/jpeg') {
                    $filename = uniqid() . '.jpg';
                } else {
                    $filename = uniqid() . '.png';
                }
                $lot['path'] = $filename;
                move_uploaded_file($tmp_name, 'uploads/' . $filename);
            }
        }
    } else {
        $errors['img'] = 'Вы не загрузили файл';
    }

    /**
     * Проверяем длину массива с ошибками
     * Если не пустой, то показываем пользователю
     */
    if (count($errors)) {
        $content = include_template('add.php', ['lot' => $lot, 'errors' => $errors, 'dict' => $dict, 'categories' => $categories]);

    } else {
        $sql = 'INSERT INTO Lot (dt_add, categories_id, user_id, name, description, start_price, step_price, img, dt_over) 
        VALUES (NOW(), ?, 1, ?, ?, ?, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($con, $sql, [$lot['category'], $lot['name'], $lot['description'], $lot['start_price'], $lot['step_price'], $lot['path'], $lot['dt_over']]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $lot_id = mysqli_insert_id($con);

            header("Location: lot.php?id=" . $lot_id);
        } else {
            $content = include_template('error.php', ['error' => mysqli_error($con)]);
        }
    }
} else {
    $content = include_template('add.php', ['categories' => $categories]);
}


$layout_content = include_template('layout.php', [
    'content' => $content,
    'categories' => $categories,
    'title' => 'Добавленный лот'
]);
print($layout_content);
