<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once '_db.php';

try {
    // Приклад вибірки всіх бронювань без фільтрації по датах
    $stmt = $db->prepare("
        SELECT 
            id,
            name,
            start,
            end,
            room_id AS resource,
            status,
            paid
        FROM reservations
        ORDER BY start
    ");
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // перетворимо поле paid у відсоток, якщо потрібно
    // і виведемо barColor (наприклад, за статусом)
    foreach ($reservations as &$r) {
        // приклад: колір залежить від статусу
        switch ($r['status']) {
            case 'Arrived':
                $r['barColor'] = '#28a745'; break;
            case 'Confirmed':
                $r['barColor'] = '#007bff'; break;
            default:
                $r['barColor'] = '#6c757d'; break;
        }
        // назва ресурсу в JS чекає властивість 'text'
        $r['text'] = $r['name'];
    }

    echo json_encode($reservations);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}