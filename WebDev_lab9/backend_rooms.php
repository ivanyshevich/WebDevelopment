<?php
require_once '_db.php';

$stmt = $db->prepare("SELECT id, name, capacity, status FROM rooms ORDER BY name");
$stmt->execute();
$rooms = $stmt->fetchAll();

header('Content-Type: application/json; charset=utf-8');
echo json_encode($rooms);