<?php
// backend_rooms.php - returns room data as JSON
header('Content-Type: application/json');
require_once '_db.php';

try {
    $stmt = $db->prepare("SELECT * FROM rooms ORDER BY name");
    $stmt->execute();
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rooms);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
