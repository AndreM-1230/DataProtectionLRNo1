<?php
session_start();
//$user_login[0] - login
//$user_login[1] - password
//$user_login[2] - condition password
//$user_login[3] - user blocked
//$_SESSION['condition'] = 0 - нет условия пароля
//$_SESSION['condition'] = 1 - есть условие пароля
//$_SESSION['corr'] = 0 - введен некорректный пароль
//$_SESSION['corr'] = 1 - учетка доступна
//$_SESSION['corr'] = 2 - учетка заблокирована
//$_SESSION['chpass'] = 0 - не нужна смена пароля
//$_SESSION['chpass'] = 1 - нужна смена пароля
//25. Чередование цифр, знаков арифметических операций и снова цифр.
function login_S(){
    //вход в систему
    $db = file_get_contents($_SESSION['db']);
    $_SESSION['db_info']=explode("\n",$db);
    $find_user = 0;
    foreach ($_SESSION['db_info'] as $value) {
        $user_login = explode(":", $value);
        if ($_POST['login'] == $user_login[0] and strlen($user_login[1]) == 0){
            $find_user = 1;
            //если не задан пароль
            switch ($user_login[3]){
                case '0':
                    //учетка доступна
                    $_SESSION['sign'] = 0;
                    $_SESSION['chpass'] = 1;
                    $_SESSION['corr'] = 1;
                    $_SESSION['login'] = $user_login[0];
                    $_SESSION['pass'] = '';
                    $_SESSION['condition'] = $user_login[2];
                    $_SESSION['message1'] = "Установи пароль";
                    header("Location: sign.php");
                    break;
                case '1':
                    //учетка забанена
                    $_SESSION['corr'] = 2;
                    $_SESSION['message1'] = "Бан";
                    header("Location: sign.php");
                    break;
            }
        }
        elseif( $_POST['login'] == $user_login[0] and $user_login[1] == $_POST['pass']){
            $find_user = 1;
            //если пароль задан
            switch ($user_login[3]){
                case '0':
                    //учетка доступна
                    switch ($user_login[2]){
                        case '0':
                            //нет условия пароля
                            $_SESSION['corr'] = 1;
                            $_SESSION['sign'] = 1;
                            $_SESSION['chpass'] = 0;
                            $_SESSION['login'] = $user_login[0];
                            $_SESSION['pass'] = $user_login[1];
                            $_SESSION['condition'] = $user_login[2];
                            header("Location: index.php");
                            break;
                        case '1':
                            //есть условие пароля
                            switch (preg_match("#[0-9]{2,}[-+*/%]{2,}[0-9]{2,}#", $_POST['pass'])){
                                case '0':
                                    //условие не соблюдается
                                    $_SESSION['sign'] = 0;
                                    $_SESSION['chpass'] = 1;
                                    $_SESSION['corr'] = 1;
                                    $_SESSION['login'] = $user_login[0];
                                    $_SESSION['pass'] = $user_login[1];
                                    $_SESSION['condition'] = $user_login[2];
                                    header("Location: sign.php");
                                    break;
                                case '1':
                                    //условие соблюдается
                                    $_SESSION['corr'] = 1;
                                    $_SESSION['sign'] = 1;
                                    $_SESSION['chpass'] = 0;
                                    $_SESSION['login'] = $user_login[0];
                                    $_SESSION['pass'] = $user_login[1];
                                    $_SESSION['condition'] = $user_login[2];
                                    header("Location: index.php");
                                    break;
                            }
                            break;
                    }
                    break;
                case '1':
                    //учетка заблокирована
                    $_SESSION['corr'] = 2;
                    header("Location: sign.php");
                    break;
            }
        }

    }
    if($find_user == 0){
        $_SESSION['message1'] = "Пользователь не найден";
        header("Location: sign.php");
    }
}

function old_pass_S(){
    //смена пароля
    $db = file($_SESSION['db'], FILE_IGNORE_NEW_LINES);
    $newpass = '';
    $newpass.= $_SESSION['login'] . ":" . $_POST['pass'] . ":" . $_SESSION['condition'] . ":" . 0;
    switch ($_POST['pass'] == $_POST['pass1']){
        //проверка подтверждения нового пароля
        case '0':
            //новые пароли не совпадают
            $_SESSION['message1'] = "Новые пароли не совпадают";
            header("Location: sign.php");
            break;
        case '1':
            //новые пароли совпадают
            switch ($_SESSION['condition'] == '1'){
                //проверка условия пароля
                case 0:
                    //нет условия пароля
                    $find_user = 0;
                    foreach ($db as $key => $value){
                        $user_login = explode(":", $value);
                        if(($_POST['oldpass'] == $user_login[1] or strlen($user_login[1]) == 0)
                            and $_SESSION['login'] == $user_login[0]) {
                            $db[$key] = $newpass;
                            $find_user = 1;
                            $_SESSION['chpass'] = 0;
                            $_SESSION['db_info'][$key] = $newpass;
                            file_put_contents("db.txt", implode("\n", $db));
                            $_SESSION['sign'] = 0;
                            $_SESSION['message1'] = "Пароль установлен";
                            header("Location: sign.php");
                            break;
                        }
                    }
                    if($find_user == 0){
                    $_SESSION['message1'] = "Некорректный логин или пароль";
                    header("Location: sign.php");
                    }
                    break;
                case 1:
                    //есть условие пароля
                    switch (preg_match("#[0-9]{2,}[-+*/%]{2,}[0-9]{2,}#", $_POST['pass'])){
                        //проверка соблюдения условия пароля
                        case 0:
                            //условие не соблюдено
                            $_SESSION['message1'] = "Пароль не соответствует условию";
                            header("Location: sign.php");
                            break;
                        case 1:
                            //условие соблюдено
                            $find_user = 0;
                            foreach ($db as $key => $value){
                                $user_login = explode(":", $value);
                                if(($_POST['oldpass'] == $user_login[1] or strlen($user_login[1]) == 0)
                                    and $_SESSION['login'] == $user_login[0]) {
                                    echo 123;
                                    $_SESSION['chpass'] = 0;
                                    $find_user = 1;
                                    $_SESSION['sign'] = 0;
                                    $db[$key] = $newpass;
                                    $_SESSION['db_info'][$key] = $newpass;
                                    $_SESSION['message1'] = "Пароль установлен";
                                    file_put_contents("db.txt", implode("\n", $db));
                                    header("Location: sign.php");
                                    break;
                                }
                            }
                            if($find_user == 0){
                            $_SESSION['message1'] = "Некорректный пароль";
                            header("Location: sign.php");
                            }
                            break;
                    }
                    break;
            }
            break;
    }
}
