<?php
session_start();
$_SESSION['sign'] = null;
header("Location: index.php");