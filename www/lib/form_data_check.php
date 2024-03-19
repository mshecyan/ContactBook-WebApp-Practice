<?php

    $config = require __DIR__ . '/../db/config.php';

    //очистка строки
    function ClearString(string $string): string {
        $string = strip_tags($string);
        $string = trim($string);
        
        return $string;
    }

    //проверка имени пользователя
    function CheckUsername(string $username): int {
        global $config;

        if (strlen($username) > $config['maxUsernameLength']) {
            return 1; //имя слишком длинное
        }

        return 0;
    }

    //проверка почты
    function CheckEmail(string $email): int {
        global $config;

        if (strlen($email) > $config['maxEmailLength']) {
            return 1; //почта слишком длинная
        }

        if (!strrchr($email, '@')) {
            return 2; //не является адресом эл. почты
        }

        return 0;
    }

    //проверка номера телефона
    function CheckPhone(string $phone): int {
        global $config;

        $phone = str_replace('+7', '8', $phone);

        if (strlen($phone) != $config['phoneLength']) {
            return 1; //неправильная длина номера
        }

        if (!is_numeric($phone)) {
            return 2; //не является телефоном
        }

        return 0;
    }

    //проверка загружаемого файла
    function CheckUploadFile(array $file): int {
        global $config;

        if (!isset($file['error']) || !$file['size'] || !$file['tmp_name']) {
            return 1; //файл отсутствует
        }

        if ($file['size'] > $config['maxFileSize']) {
            return 2; //слишком большой размер файла
        }
        
        $file_type = mime_content_type($file['tmp_name']);
        if ($file_type != 'image/png' && $file_type != 'image/jpeg') {
            return 3; //неправильный формат файла
        };

        if ($file['error'] == 0) {
            return 0;
        }

        return -1;
    }