<?php
// get-profile.php (replacement)
declare(strict_types=1);
require __DIR__ . '/config.php'; // starts session and gives db()

header('Content-Type: application/json');

$userId = $_SESSION['user']['user_id'] ?? null;
if (!$userId) {
    http_response_code(401);
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$pdo = db();
$stmt = $pdo->prepare('SELECT user_id, first_name, last_name, email, program FROM user_table WHERE user_id = ? LIMIT 1');
$stmt->execute([$userId]);
$profile = $stmt->fetch();

if (!$profile) {
    http_response_code(404);
    echo json_encode(['error' => 'Profile not found']);
    exit;
}

echo json_encode([
    'studentId' => $profile['user_id'],
    'program'   => $profile['program'],
    'fname'     => $profile['first_name'],
    'lname'     => $profile['last_name'],
    'email'     => $profile['email'],
    // phone/address not stored in current schema — return empty if not present
    'phone'     => $profile['phone'] ?? '',
    'address'   => $profile['address'] ?? ''
]);
