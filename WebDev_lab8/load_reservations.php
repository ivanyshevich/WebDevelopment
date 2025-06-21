<?php
header('Content-Type: application/json; charset=utf-8');
require 'db.php';

$stmt = $pdo->query("
  SELECT id, name, start, end, room_id, status, paid
  FROM reservations
");
$res = [];
while ($row = $stmt->fetch()) {
  // перетворюємо назви полів на ті, що розуміє DayPilot
  $res[] = [
    'id'       => $row['id'],
    'resource' => $row['room_id'],
    'start'    => $row['start'],
    'end'      => $row['end'],
    'text'     => $row['name'].' ('.$row['status'].')',
    'barColor' => getBarColor($row['status']),  // функція підбірки кольору за статусом
  ];
}
echo json_encode($res);

// допоміжна функція для статусів
function getBarColor($status) {
  switch ($status) {
    case 'Arrived':      return 'green';
    case 'Confirmed':    return 'blue';
    case 'Checked out':  return 'gray';
    case 'Expired':      return 'red';
    case 'New':          return 'orange';
    default:             return 'silver';
  }
}