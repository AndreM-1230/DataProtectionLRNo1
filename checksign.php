<?php
    session_start();
    include ('loginoldpass.php');
    $keys = array_keys($_POST);
    //echo $keys[0], $_POST['login'];
    switch ($keys[0]){
        case 'login':
            //при входе в систему
                login_S();
            break;

        case 'oldpass':
            //при смене пароля
            old_pass_S();
            break;
        default:
            header("Location: index.php");
            break;
    }

    //     if($_SESSION['chpass'] == 1 and $_SESSION['sign'] == 0){
    //         header("Location: sign.php");
    //     }

         //unset($db);
//     if ($_SESSION['corr'] == 1 and $_SESSION['sign'] == 1 and $_SESSION['chpass'] == 0){
    //         header("Location: index.php");
  //       }
//   elseif($_SESSION['corr'] == 2){
    //         header("Location: sign.php");
  //       }
//     elseif($_SESSION['corr'] == 1 and $_SESSION['sign'] == 0 and $_SESSION['chpass'] == 0){
    //         header("Location: sign.php");
    //     }else{
    //         $_SESSION['corr'] = 0;
    //         header("Location: sign.php");
    //    }

