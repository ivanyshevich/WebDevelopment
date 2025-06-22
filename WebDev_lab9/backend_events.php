<?php
require_once '_db.php';

$start = $_GET['start'] ?? $_POST['start'] ?? date('Y-m-01');
$end   = $_GET['end']   ?? $_POST['end']   ?? date('Y-m-t');

$stmt = $db->prepare("
  SELECT * FROM reservations
  WHERE NOT ((`end` <= :start) OR (`start` >= :end))
");
$stmt->bindParam(':start', $start);
$stmt->bindParam(':end',   $end);
$stmt->execute();
$rows = $stmt->fetchAll();

function barColor($status) {
  return [
    'New'         => 'orange',
    'Confirmed'   => 'blue',
    'Arrived'     => 'green',
    'CheckedOut'  => 'gray',
    'Expired'     => 'red'
  ][$status] ?? 'silver';
}

$events = [];
foreach ($rows as $r) {
  $events[] = [
    'id'        => $r['id'],
    'text'      => $r['name'],
    'start'     => $r['start'],
    'end'       => $r['end'],
    'resource'  => $r['room_id'],
    'status'    => $r['status'],
    'paid'      => $r['paid'],
    'barColor'  => barColor($r['status']),
    'bubbleHtml'=> "Reservation details: ".$r['name']
  ];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($events);