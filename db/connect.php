<?php
$dsn = "mysql:host=localhost;dbname=login_db";
$user_name = "root";
$password = "";

$con = new PDO($dsn,$user_name,$password);
$con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>