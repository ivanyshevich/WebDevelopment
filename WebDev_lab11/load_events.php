<?php
// WebDev_lab11/load_events.php
require_once '_db.php';

// для AJAX знадобляться змінні POST start та end
$start = $_POST['start'];
$end   = $_POST['end'];

$stmt = $db->prepare(
  "SELECT id, name, start, end, room_id AS resource
   FROM reservations
   WHERE NOT ((end <= :start) OR (start >= :end))"
);
$stmt->execute([':start' => $start, ':end' => $end]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// додаємо поле barColor за замовчанням
foreach ($events as &$e) {
  $e['text']     = $e['name'];
  $e['barColor'] = "#3399ff";
}
unset($e);

header('Content-Type: application/json');
echo json_encode($events);
?>
