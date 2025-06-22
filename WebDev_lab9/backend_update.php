<?php
// оновлення існуючого бронювання
require_once __DIR__ . '/_db.php';

try {
    $stmt = $db->prepare("
      UPDATE reservations
      SET
        name    = :name,
        start   = :start,
        `end`   = :end,
        room_id = :room,
        status  = :status,
        paid    = :paid
      WHERE id = :id
    ");
    $stmt->execute([
      ':id'     => $_POST['id'],
      ':name'   => $_POST['name'],
      ':start'  => $_POST['start'],
      ':end'    => $_POST['end'],
      ':room'   => $_POST['room'],
      ':status' => $_POST['status'],
      ':paid'   => $_POST['paid']
    ]);

    $response = ['result' => 'OK', 'message' => 'Update successful'];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}