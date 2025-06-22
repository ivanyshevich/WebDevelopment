<?php
// створення нового бронювання
require_once __DIR__ . '/_db.php';

try {
    $stmt = $db->prepare("
      INSERT INTO reservations
        (name, start, `end`, room_id, status, paid)
      VALUES
        (:name, :start, :end, :room, 'New', 0)
    ");
    $stmt->execute([
      ':name'  => $_POST['name'],
      ':start' => $_POST['start'],
      ':end'   => $_POST['end'],
      ':room'  => $_POST['room']
    ]);
    $id = $db->lastInsertId();

    $response = [
      'result'  => 'OK',
      'message' => "Created with id: {$id}",
      'id'      => $id
    ];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}