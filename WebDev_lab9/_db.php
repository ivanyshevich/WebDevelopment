<?php
// _db.php — коннект до MySQL через PDO

$host     = "127.0.0.1";
$port     = 3306;
$username = "root";        // ваш користувач
$password = "";            // ваш пароль
$database = "hotel_reservation";

try {
    $db = new PDO(
        "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4",
        $username,
        $password
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // якщо не вдалося підключитися — припиняємо виконання
    die("DB Connection failed: " . $e->getMessage());
}