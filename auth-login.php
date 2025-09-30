<?php
declare(strict_types=1);
require __DIR__ . '/config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /treydbuddy2/login.php'); exit; }

$role = strtolower(trim($_POST['role'] ?? ''));
$email = strtolower(trim($_POST['email'] ?? ''));
$password = $_POST['password'] ?? '';

if (!in_array($role, ['student','admin'], true)) { set_flash('error', 'Select a valid role.'); header('Location: /treydbuddy2/login.php'); exit; }
if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') { set_flash('error', 'Invalid email or password.'); header('Location: /treydbuddy2/login.php'); exit; }

$pdo = db();
$st = $pdo->prepare('SELECT user_id, first_name, last_name, email, password, role, program FROM user_table WHERE email = ? LIMIT 1');
$st->execute([$email]);
$user = $st->fetch();
// --- replace the successful-login block with this ---
// (assumes $user is the fetched DB row and $password is the submitted password)
if ($user && password_verify($password, $user['password'])) {
    // Prevent session fixation attacks:
    // regenerate the session id and remove the old one immediately.
    session_regenerate_id(true);

    // Build a consistent session shape for the rest of the app to use
    $_SESSION['user'] = [
        'user_id'    => $user['user_id'],
        'first_name' => $user['first_name'] ?? '',
        'last_name'  => $user['last_name'] ?? '',
        'email'      => $user['email'] ?? '',
        'role'       => $user['role'] ?? 'student',
        'program'    => $user['program'] ?? ''
    ];

    // Optional: remove any sensitive data in local variables
    unset($user['password']);

    // Redirect according to role (adjust paths to match your project)
    if (isset($user['role']) && $user['role'] === 'admin') {
        header('Location: /treydbuddy2/admin-dashboard.php');
    } else {
        header('Location: /treydbuddy2/student-dashboard.php');
    }
    exit;
} else {
    // Login failed: make sure we do NOT accidentally keep any old authenticated session data.
    // (Do NOT destroy the whole session if you use it for flashes; just ensure user key is unset)
    unset($_SESSION['user']);

    // Provide the same failure path you already use (flash, redirect, etc.)
    // Example:
    set_flash('error', 'Invalid credentials. Please try again.');
    header('Location: /treydbuddy2/login.php');
    exit;
}

?>


