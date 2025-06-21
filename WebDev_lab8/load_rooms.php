<?php
header('Content-Type: application/json; charset=utf-8');
require 'db.php';

$stmt = $pdo->query("SELECT id, name, capacity, status FROM rooms");
$rooms = $stmt->fetchAll();

echo json_encode($rooms);