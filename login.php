<?php
require_once('helpers.php');

session_start();

if (isset($_SESSION['user'])){
    header("Location: /");
    exit();
}


$con = mysqli_connect("localhost", "root", "", "yeticave");

mysqli_set_charset($con, "utf8");

/*Запрос на название и спец. ключ категорий */
$sql = "SELECT name, slug, id FROM Categories";
$result = mysqli_query($con, $sql);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);


$content = include_template('login.php', ['categories' => $categories]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;

    //Определяем обязательные поля
    $required_fields = ['email', 'password'];
    $dict = ['email' => 'Email', 'password' => 'Пароль'];
    $errors = [];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }
    }

    foreach ($_POST as $key => $value) {
        if ($key == 'email') {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL) && !count($errors['email']) ){
                $errors[$key] = 'Неверный формат email';
            }
        }
    }

    $email = mysqli_real_escape_string($con, $form['email']);
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $res = mysqli_query($con, $sql);

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    if (!count($errors) and $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    } else if (!count($errors)) {
        $errors['email'] = 'Такой пользователь не найден';
    }

    if (count($errors)) {
        $content = include_template('login.php', ['form' => $form, 'errors' => $errors, 'dict' => $dict, 'categories' => $categories]);
    } else {
        header("Location: /index.php");
        exit();
    }
} else {
    $content = include_template('login.php', ['categories' => $categories]);
}

$layout_content = include_template('layout.php', [
    'content' => $content,
    'categories' => $categories,
    'title' => 'Форма входа'
]);

print($layout_content);