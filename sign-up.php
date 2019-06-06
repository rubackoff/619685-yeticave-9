<?php
require_once('helpers.php');


$con = mysqli_connect("localhost", "root", "", "yeticave");

mysqli_set_charset($con, "utf8");

/*Запрос на название и спец. ключ категорий */
$sql = "SELECT name, slug, id FROM Categories";
$result = mysqli_query($con, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);


$content = include_template('sign-up.php', ['categories' => $categories]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;

    //Определяем обязательные поля
    $required_fields = ['email', 'password', 'name', 'message'];
    $dict = ['email' => 'Email', 'password' => 'Пароль', 'name' => 'Имя пользователя', 'message' => 'Контактные данные'];
    $errors = [];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }
    }
    //Проверяем формат email
    foreach ($_POST as $key => $value) {
        if ($key == 'email') {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$key] = 'Неверный формат email';
            }
        }
    }

    /*
     * Проверяем введённый email на наличие в Бд
     * Если нет пользователя с данным email
     * Хэшируем пароль
     * Делаем запрос на добавление данных из формы в БД
     */
    if (empty($errors)) {
        $email = mysqli_real_escape_string($con, $form['email']);
        $sql = "SELECT id FROM User WHERE email = '$email'";
        $res = mysqli_query($con, $sql);

        if (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        } else {
            $password = password_hash($form['password'], PASSWORD_DEFAULT);

            $sql = 'INSERT INTO User (dt_add, email, name, password) 
            VALUES (NOW(), ?, ?, ?)';
            $stmt = db_get_prepare_stmt($con, $sql, [$form['email'], $form['name'], $password]);
            $res = mysqli_stmt_execute($stmt);
        }
    }
    //Если форма отправилась, то перенаправляем пользователя на страницу входа
    if ($res && empty($errors)) {
        header("Location: /login.php");
        exit();
    } else {
        $content = include_template('sign-up.php', ['form' => $form, 'errors' => $errors, 'dict' => $dict, 'categories' => $categories]);
    }
} else {
    $content = include_template('sign-up.php', ['categories' => $categories]);
}


$layout_content = include_template('layout.php', [
    'content' => $content,
    'categories' => $categories,
    'title' => 'Форма регистрации нового пользователя'
]);
print($layout_content);