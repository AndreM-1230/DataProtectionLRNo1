<?php
session_start();

$db = '';
$db .= $_POST['login'] . ":" . '' . ":" . $_POST['condition'] . ":" . 0;
array_push($_SESSION['db_info'], $db);
//file_put_contents("db.txt", $db);
//echo $_SESSION['db_info'][0], $_SESSION['db_info'][1], $_SESSION['db_info'][2];
header("Location: index.php");
