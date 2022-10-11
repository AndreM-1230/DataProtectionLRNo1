<?php
    session_start();
    $keys = array_keys($_POST);
    //echo $keys[0], $_POST['login'];
    switch ($keys[0]){
        case 'login':
            $db = file_get_contents("db.txt");
            $_SESSION['db_info']=explode("\n",$db);
            foreach ($_SESSION['db_info'] as $value) {

                $user_login = explode(":", $value);
                //echo $_POST['login'], ' ', $user_login[0], ' ' ,$user_login[1], ' ', $_POST['pass'];
                //echo $user_login[3];
                if ($_POST['login'] == $user_login[0] and $user_login[1] == '') {
                    //если не задан пароль
                    if($user_login[3] == '1'){
                        //учетка забанена
                        $_SESSION['corr'] = 2;
                        header("Location: sign.php");
                    }
                    else{
                        //учетка доступна
                        $_SESSION['sign'] = 0;
                        $_SESSION['chpass'] = 1;
                        $_SESSION['corr'] = 1;
                        $_SESSION['login'] = $user_login[0];
                        $_SESSION['pass'] = '';
                        $_SESSION['condition'] = $user_login[2];
                        header("Location: sign.php");
                    }
                }
                elseif( $_POST['login'] == $user_login[0] and $user_login[1] == $_POST['pass']){
                    if($user_login[3] == '1'){
                        $_SESSION['corr'] = 2;
                        header("Location: sign.php");
                    }
                    elseif($user_login[2] == '1' and 0 == preg_match("#[0-9]{2,}[-+*/%]{2,}[0-9]{2,}#", $_POST['pass'])){
                        $_SESSION['sign'] = 0;
                        $_SESSION['chpass'] = 1;
                        $_SESSION['corr'] = 1;
                        $_SESSION['login'] = $user_login[0];
                        $_SESSION['pass'] = $user_login[1];
                        $_SESSION['condition'] = $user_login[2];
                        header("Location: sign.php");
                    }
                    else{
                        $_SESSION['corr'] = 1;
                        $_SESSION['sign'] = 1;
                        $_SESSION['login'] = $user_login[0];
                        $_SESSION['pass'] = $user_login[1];
                        $_SESSION['condition'] = $user_login[2];
                        header("Location: index.php");
                    }
                }
            }
            break;

        case 'oldpass':
            $db = file("db.txt", FILE_IGNORE_NEW_LINES);
            if($_SESSION['condition'] == '1'){
                if(preg_match("#[0-9]{2,}[-+*/%]{2,}[0-9]{2,}#", $_POST['pass'])){

                        $newpass = '';
                        $newpass.= $_SESSION['login'] . ":" . $_POST['pass'] . ":" . $_SESSION['condition'] . ":" . 0;

                        foreach ($db as $key => $value){
                            $user_login = explode(":", $value);
                            //echo $user_login[0] .' ' . $user_login[1] . ' ';
                            if($_POST['oldpass'] == $user_login[1] and $_SESSION['login'] == $user_login[0]) {
                                echo 123;
                                $_SESSION['chpass'] = 0;
                                $db[$key] = $newpass;
                                //echo $_SESSION['db_info'][$key];
                                $_SESSION['db_info'][$key] = $newpass;
                                file_put_contents("db.txt", implode("\n", $db));
                                header("Location: signout.php");
                            }

                        }
                }
                else{
                    header("Location: sign.php");
                }
            }
            else{
                $newpass = '';
                $newpass.= $_SESSION['login'] . ":" . $_POST['pass'] . ":" . $_SESSION['condition'] . ":" . 0;
                echo $_SESSION['pass'] , ':' ,  $_SESSION['login'],':' , $_POST['pass'];
                foreach ($db as $key => $value){
                    $user_login = explode(":", $value);
                    //echo $user_login[0] .' ' . $user_login[1] . ' ';
                    if($_POST['oldpass'] == $user_login[1] and $_SESSION['login'] == $user_login[0]) {
                        $db[$key] = $newpass;
                        //echo $_SESSION['db_info'][$key];
                        $_SESSION['db_info'][$key] = $newpass;
                        file_put_contents("db.txt", implode("\n", $db));
                        $_SESSION['sign'] = 0;
                        header("Location: signout.php");
                    }

                }
            }

            break;
        default:
            header("Location: sign.php");
            break;
    }


    //echo $_SESSION['sign'], $_SESSION['corr'], $_SESSION['chpass'] = 1;

         if($_SESSION['chpass'] == 1 and $_SESSION['sign'] == 0){
             header("Location: sign.php");
         }

         //unset($db);
         if ($_SESSION['corr'] == 1 and $_SESSION['sign'] == 1 and $_SESSION['chpass'] == 0){
             header("Location: index.php");
         }
         elseif($_SESSION['corr'] == 2){
             header("Location: sign.php");
         }
         else{
             $_SESSION['corr'] = 0;
             header("Location: sign.php");
         }

