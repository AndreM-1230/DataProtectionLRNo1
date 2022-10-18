<?php
session_start();
$_SESSION['sign'] = null;
$_SESSION['db'] = null;
header("Location: index.php");