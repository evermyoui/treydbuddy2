<?php
declare(strict_types=1);
require dirname(__DIR__) . '/config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /treydbuddy2/auth/register.php'); exit; }

$role = strtolower(trim($_POST['role'] ?? ''));
$first = trim($_POST['first_name'] ?? '');
$last = trim($_POST['last_name'] ?? '');
$idNumber = trim($_POST['id_number'] ?? '');
$program = trim($_POST['program'] ?? '');
$email = strtolower(trim($_POST['email'] ?? ''));
$password = $_POST['password'] ?? '';
$passwordConfirm = $_POST['password_confirm'] ?? '';

if (!in_array($role, ['student','admin'], true)) { set_flash('error', 'Select a valid role.'); header('Location: /treydbuddy2/auth/register.php'); exit; }
if (!$first || !$last || !$idNumber || !$program || !filter_var($email, FILTER_VALIDATE_EMAIL)) { set_flash('error', 'Fill all fields correctly.'); header('Location: /treydbuddy2/auth/register.php'); exit; }
if (strlen($password) < 8 || $password !== $passwordConfirm) { set_flash('error', 'Passwords must match and be at least 8 chars.'); header('Location: /treydbuddy2/auth/register.php'); exit; }
if (strlen($idNumber) > 20) { set_flash('error', 'ID number max 20 characters.'); header('Location: /treydbuddy2/auth/register.php'); exit; }

$pdo = db();
$q = $pdo->prepare('SELECT 1 FROM user_table WHERE user_id = ? OR email = ? LIMIT 1');
$q->execute([$idNumber, $email]);
if ($q->fetch()) { set_flash('error', 'ID or email already exists.'); header('Location: /treydbuddy2/auth/register.php'); exit; }

$hash = password_hash($password, PASSWORD_DEFAULT);
$ins = $pdo->prepare('INSERT INTO user_table (user_id, last_name, first_name, email, password, role, program) VALUES (?,?,?,?,?,?,?)');
$ins->execute([$idNumber, $last, $first, $email, $hash, $role, $program]);

$_SESSION['user'] = ['user_id'=>$idNumber,'first_name'=>$first,'last_name'=>$last,'email'=>$email,'role'=>$role,'program'=>$program];
header('Location: ' . ($role === 'admin' ? '/treydbuddy2/admin/admin-dashboard.php' : '/treydbuddy2/student/student-dashboard.php'));
exit;
?>


