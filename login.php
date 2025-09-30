<?php
require __DIR__ . '/config.php';
if (isset($_SESSION['user'])) { header('Location: ' . (($_SESSION['user']['role'] ?? '') === 'admin' ? '/treydbuddy2/admin-dashboard.php' : '/treydbuddy2/student-dashboard.php')); exit; }
$error = get_flash('error') ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TreydBuddy — Login</title>
  <link rel="stylesheet" href="./assets/auth.css" />
</head>
<body>
  <main class="auth-shell">
    <section class="auth" role="region" aria-label="TreydBuddy Login">
      <aside class="auth-hero">
        <a class="brand" href="#" aria-label="TreydBuddy Home">
          <span class="logo">TB</span>
          <span>TreydBuddy</span>
        </a>
        <h1 class="hero-title">Event Reservations & Attendance<br />for BPSU-TREYD</h1>
        <p class="hero-footnote">BPSU-TREYD • TREYDBUDDY</p>
      </aside>
      <div class="auth-form">
        <?php if ($error): ?><div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <form class="form-card" action="/treydbuddy2/auth-login.php" method="post" novalidate>
          <div class="form-header">
            <h2>Welcome back</h2>
            <a href="register.php">Create an account</a>
          </div>
          <div class="form-row">
            <div>
              <label class="label" for="role">Sign in as</label>
              <select id="role" name="role" class="select" required>
                <option value="" disabled selected>Select role</option>
                <option value="student">Student</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div>
              <label class="label" for="email">Email</label>
              <input id="email" name="email" class="input" type="email" inputmode="email" autocomplete="email" placeholder="name@student.bpsu.edu.ph" required />
            </div>
            <div>
              <label class="label" for="password">Password</label>
              <input id="password" name="password" class="input" type="password" autocomplete="current-password" placeholder="••••••••" minlength="8" required />
            </div>
            <div class="actions">
              <button class="btn btn-primary" type="submit">Sign In</button>
            </div>
          </div>
        </form>
      </div>
    </section>
  </main>
</body>
</html>


