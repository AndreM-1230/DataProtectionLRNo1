<?php
session_start();

$db = file_get_contents($_SESSION['db']);
$db .= "\r\n" . $_POST['login'] . ":" . '' . ":" . $_POST['condition'] . ":" . 0;
file_put_contents("db.txt", $db);
header("Location: index.php");
