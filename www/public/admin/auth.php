<?php
    $config = require __DIR__ . '/../../db/config.php';

    //проверка логина и пароля из формы и авторизация
    if (!isset($_POST['username'])) {
        $errorMessage = 'Не указан логин';
        header("Location: /login.php?error={$errorMessage}");
        exit();
    }

    if (!isset($_POST['password'])) {
        $errorMessage = 'Не указан пароль';
        header("Location: /login.php?error={$errorMessage}");
        exit();
    }


    if (!($_POST['username'] === $config['adminLogin'] && $_POST['password'] === $config['adminPassword'])) {
        $errorMessage = 'Неверный логин или пароль';
        header("Location: /login.php?error={$errorMessage}");
        exit();
    }

    session_start();
    $_SESSION['admin'] = $_POST['username'];

    header('Location: /admin/');