<?php
require_once '_db.php';

$stmt = $db->prepare("
  UPDATE reservations
  SET name = :name, start = :start, `end` = :end,
      room_id = :room, status = :status, paid = :paid
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

$res = ['result'=>'OK','message'=>'Update successful'];
header('Content-Type: application/json');
echo json_encode($res);