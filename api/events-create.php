<?php
declare(strict_types=1);
require dirname(__DIR__) . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  header('Allow: POST');
  exit;
}

header('Content-Type: application/json');

try {
  $pdo = db();
  $pdo->beginTransaction();

  // Parse body (supports x-www-form-urlencoded and JSON)
  $ct = strtolower($_SERVER['CONTENT_TYPE'] ?? '');
  if (str_contains($ct, 'application/json')) {
    $raw = file_get_contents('php://input');
    $json = json_decode($raw, true) ?: [];
    $_POST = $json + $_POST;
  }

  // Next event id generator: EVENT-001, EVENT-002, ... using numeric suffix
  $max = $pdo->query("SELECT MAX(CAST(SUBSTRING(event_id, 7) AS UNSIGNED)) FROM event_table WHERE event_id LIKE 'EVENT-%'")->fetchColumn();
  $seq = (int)$max + 1;
  $nextId = sprintf('EVENT-%03d', max(1, $seq));

  $name = trim($_POST['event_name'] ?? '');
  $date = trim($_POST['event_date'] ?? '');
  $location = trim($_POST['location'] ?? '');
  $description = trim($_POST['description'] ?? '');

  if ($name === '' || $date === '') { throw new RuntimeException('Missing required fields'); }

  $stmt = $pdo->prepare('INSERT INTO event_table (event_id, event_name, event_date, location, description) VALUES (?,?,?,?,?)');
  $stmt->execute([$nextId, $name, $date, $location ?: null, $description ?: null]);

  $pdo->commit();
  echo json_encode(['ok' => true, 'event_id' => $nextId]);
} catch (Throwable $e) {
  if ($pdo?->inTransaction()) { $pdo->rollBack(); }
  http_response_code(400);
  echo json_encode(['error' => 'Failed to create event', 'detail' => $e->getMessage()]);
}
?>


