<?php
session_start();
//$db = file($_SESSION['db'], FILE_IGNORE_NEW_LINES);
$key = md5($_POST['key']);
// Шифруем содержимое файла
$_SESSION['db_info'] = 'admin::0:0';
$contetsEncrypted = openssl_encrypt($_SESSION['db_info'], "AES-128-ECB", $key);
file_put_contents($_SESSION['db'], $contetsEncrypted);
header("Location: sign.php");