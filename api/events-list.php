<?php
declare(strict_types=1);
require dirname(__DIR__) . '/config.php';

header('Content-Type: application/json');

try {
    $pdo = db();
    $stmt = $pdo->query('SELECT event_id, event_name, event_date, location, description FROM event_table ORDER BY event_date DESC');
    $rows = $stmt->fetchAll();

    // Map to frontend-friendly shape while keeping original fields
    $out = array_map(function(array $r) {
        return [
            'event_id'   => $r['event_id'],
            'event_name' => $r['event_name'],
            'event_date' => $r['event_date'],
            'location'   => $r['location'],
            'description'=> $r['description'],
            // Frontend compatibility fields
            'id'         => $r['event_id'],
            'title'      => $r['event_name'],
            'date'       => $r['event_date'],
            'slots'      => 0,
            'reserved'   => 0,
            'status'     => 'Open'
        ];
    }, $rows);

    echo json_encode($out);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to load events']);
}
?>


