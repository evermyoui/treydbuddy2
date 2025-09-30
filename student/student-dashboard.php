<?php
require dirname(__DIR__) . '/config.php';
require_role('student');
$user = $_SESSION['user'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TreydBuddy — Student Dashboard</title>
  <link rel="stylesheet" href="../assets/student.css" />
</head>
<body>
  <?php include __DIR__ . '/student-dashboard.html'; ?>
  <script>
    // You can fetch and hydrate data here via fetch('/api/...')
  </script>
</body>
</html>


