<?php

    //проверка существования куки
    if (isset($_COOKIE['form_send_success'])) {
		$message = 'Форма успешно отправлена';
        require __DIR__ . '/../templates/header_template.tpl.php';
        require __DIR__ . '/../templates/message_page_template.tpl.php';
        require __DIR__ . '/../templates/footer_template.tpl.php';
    }
    else {
        $errorMessage = "";
        if (isset($_GET['error'])) {
            $errorMessage = $_GET['error'];
        }
        
        require __DIR__ . '/../templates/header_template.tpl.php';
        require __DIR__ . '/../templates/userform_template.tpl.php';
        require __DIR__ . '/../templates/footer_template.tpl.php';
    }