<?php

    $config = require __DIR__ . '/../../db/config.php';
    $dbh = require __DIR__ . '/../../db/pdo.php';

    session_start();

    //проверка существаования сессии и авторизации
    if (!isset($_SESSION['admin'])) {
        header('Location: /../login.php');
        exit();
    }

    //получение общего количества записей
    $stmt = 'SELECT COUNT(*) FROM contacts';
    $contacts = $dbh->query($stmt);
    $totalContactsCount = $contacts->fetch()[0];
    $pagesCount = ceil($totalContactsCount / $config['contactsInPage']);
    
    //определение текущей страницы
    if(!isset($_GET['page'])) {
        $page = 1;
    }
    else {
        if (!is_numeric($_GET['page'])) {
            $page = 1;
        }
        elseif ((int) $_GET['page'] > $pagesCount) {
            $page = $pagesCount;
            header("Location: /admin/index.php?page={$page}");
            exit();
        }
        else {
            $page = (int) $_GET['page'];
        }
    }

    //получение записей для текущей страницы
    $offset = ($page - 1) * $config['contactsInPage'];
    $stmt = $dbh->prepare('SELECT * FROM contacts ORDER BY on_reg DESC LIMIT :limit OFFSET :offset');
    $stmt->bindParam(':limit', $config['contactsInPage'], PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $contacts = $stmt->fetchAll();
    
    require __DIR__ . '/../../templates/admin_header_template.tpl.php';
    require __DIR__ . '/../../templates/admin_panel_template.tpl.php';
    require __DIR__ . '/../../templates/footer_template.tpl.php';