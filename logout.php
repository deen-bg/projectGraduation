<?php
session_start();
session_destroy();
header('location: Form_login.php');
?>