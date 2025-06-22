<?php
// WebDev_lab10/load_rooms.php
header('Content-Type: application/json');

require_once '_db.php';

try {
    $stmt = $db->prepare("SELECT * FROM rooms ORDER BY name");
    $stmt->execute();
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // повертаємо JSON
    echo json_encode($rooms);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
