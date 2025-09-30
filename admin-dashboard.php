<?php
require __DIR__ . '/config.php';
require_role('admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TreydBuddy — Admin Dashboard</title>
  <link rel="stylesheet" href="./assets/dashboard.css" />
</head>
<body>
  <?php include __DIR__ . '/admin-dashboard.html'; ?>
</body>
</html>


