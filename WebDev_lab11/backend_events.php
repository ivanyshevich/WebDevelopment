<?php
require_once "_db.php";

// Отримуємо від клієнта видимий інтервал
$start = $_POST['start'];
$end   = $_POST['end'];

// Витягаємо бронювання та відразу формуємо необхідні поля
$stmt = $db->prepare(
    "SELECT id,
            room_id AS resource,
            name    AS text,
            start,
            end,
            status,
            paid
       FROM reservations
      WHERE NOT ((end <= :start) OR (start >= :end))"
);
$stmt->execute([':start' => $start, ':end' => $end]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($events);
