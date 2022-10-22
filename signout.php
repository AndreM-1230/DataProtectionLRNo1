<?php
session_start();
$_SESSION['sign'] = null;
$_SESSION['db'] = null;
$_SESSION['crypt'] = null;
header("Location: index.php");