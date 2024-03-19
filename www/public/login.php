<?php

	session_start();

	//проверка существования сессии и авторизация
	if(isset($_SESSION['admin'])) {
		header('Location: /admin/');
		exit();
	}

	$errorMessage = "";
	if (isset($_GET['error'])) {
		$errorMessage = $_GET['error'];
	}
	
	require __DIR__ . '/../templates/header_template.tpl.php';
	require __DIR__ . '/../templates/login_template.tpl.php';
	require __DIR__ . '/../templates/footer_template.tpl.php';
