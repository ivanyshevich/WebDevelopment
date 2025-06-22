<?php
// backend_rooms.php - returns room data as JSON
header('Content-Type: application/json');
require_once '_db.php';

try {
    $capacity = isset($_POST['capacity']) ? $_POST['capacity'] : '0';
    $stmt = $db->prepare("SELECT * FROM rooms WHERE capacity = :capacity OR :capacity = '0' ORDER BY name");
    $stmt->bindParam(':capacity', $capacity);
    $stmt->execute();
    $rooms = $stmt->fetchAll();

    class Room {}
    $result = [];
    foreach ($rooms as $room) {
        $r = new Room();
        $r->id = $room['id'];
        $r->name = $room['name'];
        $r->capacity = $room['capacity'];
        $r->status = $room['status'];
        $result[] = $r;
    }
    echo json_encode($result);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
