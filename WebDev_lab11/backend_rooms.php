<?php
// backend_rooms.php - returns room data as JSON
header('Content-Type: application/json');
require_once '_db.php';

try {
    $capacity = $_POST['capacity'];
    $stmt = $db->prepare("SELECT * FROM rooms WHERE capacity = :capacity OR :capacity = '0' ORDER BY name");
    $stmt->bindParam(':capacity', $capacity);
    $stmt->execute();
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rooms);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
