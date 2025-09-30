<?php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$DB_HOST = '127.0.0.1';
$DB_NAME = 'treyd_buddy';
$DB_USER = 'root';
$DB_PASS = '';
$DB_CHARSET = 'utf8mb4';

function db(): PDO {
    static $pdo = null;
    if ($pdo) return $pdo;
    global $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS, $DB_CHARSET;
    $dsn = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset={$DB_CHARSET}";
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    return $pdo;
}

function require_role(string $role): void {
    if (!isset($_SESSION['user'])) { header('Location: /treydbuddy2/login.php'); exit; }
    if ($role !== 'any' && (($_SESSION['user']['role'] ?? '') !== $role)) {
        header('Location: ' . (($_SESSION['user']['role'] ?? '') === 'admin' ? '/treydbuddy2/admin-dashboard.php' : '/treydbuddy2/student-dashboard.php'));
        exit;
    }
}

function set_flash(string $k, string $m): void { $_SESSION['flash'][$k] = $m; }
function get_flash(string $k): ?string { if (!isset($_SESSION['flash'][$k])) return null; $m = $_SESSION['flash'][$k]; unset($_SESSION['flash'][$k]); return $m; }
?>


