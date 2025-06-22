<?php
require_once "_db.php";

$stmt = $db->prepare("DELETE FROM reservations WHERE id = :id");
$stmt->execute([':id' => $_POST['id']]);

$response = ['result'=>'OK','message'=>'Deleted'];
header('Content-Type: application/json');
echo json_encode($response);