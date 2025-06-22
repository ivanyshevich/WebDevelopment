<?php
// завантаження бронювань у заданому інтервалі
require_once __DIR__ . '/_db.php';

// отримуємо діапазон (у режимі AJAX це POST, для тесту можна GET)
$start = $_REQUEST['start'] ?? date('Y-m-01');
$end   = $_REQUEST['end']   ?? date('Y-m-t');

try {
    $stmt = $db->prepare("
        SELECT id, name, start, `end`, room_id AS resource, status, paid
        FROM reservations
        WHERE NOT ((`end` <= :start) OR (`start` >= :end))
    ");
    $stmt->execute([':start' => $start, ':end' => $end]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /* додаємо поле bubbleHtml і колір */
    $events = [];
    foreach ($rows as $r) {
        $r['bubbleHtml'] = "Reservation details: {$r['name']}";
        // можна за status підбирати barColor, наприклад:
        $r['barColor'] = ($r['status'] === 'New') ? 'orange' : 'gray';
        $events[] = $r;
    }

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($events);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}