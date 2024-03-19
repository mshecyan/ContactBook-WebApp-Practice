<?php
    
    $config = require __DIR__ . '/../../db/config.php';
    $dbh = require __DIR__ . '/../../db/pdo.php';

    session_start();

    //проверка авторизации
    if (!isset($_SESSION['admin'])) {
        $errorMessage = 'Вы не авторизованы';
        header("Location: /../login.php?error={$errorMessage}");
        exit();
    }

    //удаление записи
    if (!isset($_GET['id'])) {
        exit();
    }
    if (!is_numeric($_GET['id'])) {
        exit();
    }

    $id = (int) $_GET['id'];
    $stmt = $dbh->prepare('DELETE FROM contacts WHERE id = :id');
    $stmt->execute([':id' => $id]);

    if (!isset($_GET['page'])) {
        $page = 1;
    }
    else {
        $page = (is_numeric($_GET['page'])) ? (int) $_GET['page'] : 1;
    }

    header("Location: /admin/index.php?page={$page}");