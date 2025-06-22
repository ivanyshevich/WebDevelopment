<?php
// видалення бронювання
require_once __DIR__ . '/_db.php';

try {
    $stmt = $db->prepare("DELETE FROM reservations WHERE id = :id");
    $stmt->execute([':id' => $_POST['id']]);

    $response = ['result' => 'OK', 'message' => 'Deleted'];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}