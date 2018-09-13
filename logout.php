<?php
session_start();
require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;

session_destroy();
header('location: Form_login.php');
?>