<?php
require_once "_db.php";

// для перевірки GET → POST змінити параметри відповідно
$start = $_POST['start'];
$end   = $_POST['end'];

$stmt = $db->prepare("
  SELECT * 
    FROM reservations 
   WHERE NOT ((end <= :start) OR (start >= :end))
");
$stmt->execute([':start' => $start, ':end' => $end]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($events);