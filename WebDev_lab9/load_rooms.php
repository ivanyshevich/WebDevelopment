<?php
// завантаження списку кімнат у форматі JSON
require_once __DIR__ . '/_db.php';

try {
    $stmt = $db->query("SELECT id, name, capacity, status FROM rooms ORDER BY name");
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($rooms);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}