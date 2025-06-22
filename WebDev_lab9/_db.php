<?php
/* Підключення до MySQL через PDO (один раз для всіх скриптів) */
$host = "127.0.0.1";
$port = 3306;
$username = "root";
$password = "";
$database = "hotel_reservation";

$db = new PDO("mysql:host=$host;port=$port;charset=utf8mb4",
               $username,
               $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->exec("USE `$database`");
?>