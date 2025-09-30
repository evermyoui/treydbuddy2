<?php
require dirname(__DIR__) . '/config.php';
require_role('student');
$user = $_SESSION['user'] ?? [];
include __DIR__ . '/student-dashboard.html';
?>


