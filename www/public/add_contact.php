<?php

    include __DIR__ . '/../lib/form_data_check.php';
    $config = require __DIR__ . '/../db/config.php';
    $dbh = require __DIR__ . '/../db/pdo.php';


    //проверка существования куки
    if (isset($_COOKIE['form_send_success'])) {
        header("Location: /userform.php");
        exit();
    }


    //проверка имени пользователя
    if (!isset($_POST['username'])) {
        $errorMessage = 'Указано пустое имя';
        header("Location: /userform.php?error={$errorMessage}");
        exit();
    }
    else {
        $username = ClearString($_POST["username"]);
        $checkUsernameErrorCode = CheckUsername($username);
        if ($checkUsernameErrorCode == 1) {
            $errorMessage = 'Указанное имя слишком длинное';
            header("Location: /userform.php?error={$errorMessage}");
            exit(); 
        }
    }


    //проверка почты
    if (!isset($_POST['email'])) {
        $errorMessage = 'Указан пустой адрес эл. почты';
        header("Location: /userform.php?error={$errorMessage}");
        exit();
    }
    else {
        $email = ClearString($_POST["email"]);
        $checkEmailErrorCode = CheckEmail($email);
        if ($checkEmailErrorCode == 1) {
            $errorMessage = 'Указанный адрес эл. почты слишком длинный';
            header("Location: /userform.php?error={$errorMessage}");
            exit(); 
        }
        elseif ($checkEmailErrorCode == 2) {
            $errorMessage = 'Указанный адрес не является эл. почтой';
            header("Location: /userform.php?error={$errorMessage}");
            exit(); 
        }
    }


    //проверка телефона
    if (!isset($_POST['phone'])) {
        $errorMessage = 'Указан пустой номер телефона';
        header("Location: /userform.php?error={$errorMessage}");
        exit();
    }
    else {
        $phone = ClearString($_POST["phone"]);
        $checkPhoneErrorCode = CheckPhone($phone);
        if ($checkPhoneErrorCode == 1) {
            $errorMessage = 'Неверная длина номера';
            header("Location: /userform.php?error={$errorMessage}");
            exit(); 
        }
        elseif ($checkPhoneErrorCode == 2) {
            $errorMessage = 'Указанный номер не является телефоном';
            header("Location: /userform.php?error={$errorMessage}");
            exit(); 
        }
    }


    //проверка загружаемого файла
    $checkUploadFileErrorCoded = CheckUploadFile($_FILES['photo']);
    switch ($checkUploadFileErrorCoded) {
        case 0:
            $tmpPhotoPath = $_FILES['photo']['tmp_name'];
            $photoFilename = $_FILES['photo']['name'];
            $photoPath = '/resources/uploads/' . uniqid() . $photoFilename;

            $fileMoveSuccess = move_uploaded_file($tmpPhotoPath, __DIR__ . $photoPath);
            if (!$fileMoveSuccess) {
                $errorMessage = 'При выполнении команды произошла ошибка';
                header("Location: /userform.php?error={$errorMessage}");
                exit(); 
            }

            break;
        
        case 1:
            $photoPath = '/resources/images/person.svg';
            break;

        case 2:
            $errorMessage = 'Размер загружаемого файла не должен превышать 2 Мб';
            header("Location: /userform.php?error={$errorMessage}");
            exit();

        case 3:
            $errorMessage = 'Загружаемый файл должен иметь формат jpg или png';
            header("Location: /userform.php?error={$errorMessage}");
            exit();           

        default:
            $errorMessage = 'Во время загрузки файла произошла ошибка. Повторите попытку';
            header("Location: /userform.php?error={$errorMessage}");
            exit();
    }

    
    //добавление контактов в БД
    $stmt = $dbh->prepare('INSERT INTO contacts (name, email, phone, photo) VALUES (:name, :email, :phone, :photo)');
    $insertResult = $stmt->execute([':name' => $username, ':email' => $email, ':phone' => $phone, ':photo' => $photoPath]);
    if ($insertResult == 0) {
        $errorMessage = 'При выполнении команды произошла ошибка';
        header("Location: /userform.php?error={$errorMessage}");
        exit(); 
    }

    //пометить пользователя кукой
    setcookie("form_send_success", $username, time() + $config['coockieLifeTime']);
    header('Location: /userform.php');