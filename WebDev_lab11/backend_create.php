<?php
require_once "_db.php";

$stmt = $db->prepare("
  INSERT INTO reservations 
    (name, start, end, room_id, status, paid) 
  VALUES 
    (:name, :start, :end, :room, 'New', 0)
");
$stmt->execute([
  ':name'  => $_POST['name'],
  ':start' => $_POST['start'],
  ':end'   => $_POST['end'],
  ':room'  => $_POST['room']
]);

$response = [
  'result'  => 'OK',
  'message' => 'Created',
  'id'      => $db->lastInsertId()
];
header('Content-Type: application/json');
echo json_encode($response);
