<?php
session_start();
$db = file_get_contents($_SESSION['db']);
$_SESSION['key'] = md5($_POST['key']);
echo $_SESSION['key'];
$db = openssl_decrypt($db, "AES-128-ECB", $_SESSION['key']);
$db = explode("\n",$db);
file_put_contents('aes.txt', $db);
$find = 0;
foreach ($db as $key => $value){
    $user_login = explode(":", $value);
    //echo $user_login[0], $user_login[2], $user_login[3];
    if('admin' == $user_login[0]) {
        $find = 1;
        echo $user_login[0];
        $_SESSION['db_info'] = $db;
        $_SESSION['crypt'] = 2;
        break;
    }

}
switch($find){
    case 0:
        header("Location: crypt.php?result=passerror");
        break;
    case 1:
        header("Location: sign.php");
        break;
}
