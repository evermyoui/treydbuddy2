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
  <title>TreydBuddy — Create Account</title>
  <link rel="stylesheet" href="./assets/auth.css" />
</head>
<body>
  <main class="auth-shell">
    <section class="auth" role="region" aria-label="TreydBuddy Registration">
      <aside class="auth-hero">
        <a class="brand" href="login.php" aria-label="TreydBuddy Home">
          <span class="logo">TB</span>
          <span>TreydBuddy</span>
        </a>
        <h1 class="hero-title">Join TreydBuddy</h1>
        <p class="hero-sub">Create your account to reserve tickets, track attendance, and stay updated on campus events.</p>
        <p class="hero-footnote">Need to sign in? <a href="login.php" style="color:#ff0000; text-decoration:none;">Go to Login</a></p>
      </aside>
      <div class="auth-form">
        <?php if ($error): ?><div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
        <form class="form-card" action="/treydbuddy2/auth-register.php" method="post" novalidate>
          <div class="form-header">
            <h2>Create your account</h2>
            <a href="login.php">I have an account</a>
          </div>
          <div class="form-row">
            <div>
              <label class="label" for="reg-role">Register as</label>
              <select id="reg-role" name="role" class="select" required>
                <option value="" disabled selected>Select role</option>
                <option value="student">Student</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div class="grid-2">
              <div>
                <label class="label" for="fname">First Name</label>
                <input id="fname" name="first_name" class="input" type="text" autocomplete="given-name" placeholder="Juan" required />
              </div>
              <div>
                <label class="label" for="lname">Last Name</label>
                <input id="lname" name="last_name" class="input" type="text" autocomplete="family-name" placeholder="Dela Cruz" required />
              </div>
            </div>
            <div class="grid-2">
              <div>
                <label class="label" for="studentno">Student / Employee No.</label>
                <input id="studentno" name="id_number" class="input" type="text" inputmode="numeric" placeholder="e.g., 2025-12345" required />
              </div>
              <div>
                <label class="label" for="program">Program / Department</label>
                <input id="program" name="program" class="input" type="text" placeholder="e.g., BSIT" required />
              </div>
            </div>
            <div>
              <label class="label" for="reg-email">Email</label>
              <input id="reg-email" name="email" class="input" type="email" inputmode="email" autocomplete="email" placeholder="name@student.bpsu.edu.ph" required />
            </div>
            <div class="grid-2">
              <div>
                <label class="label" for="reg-pass">Password</label>
                <input id="reg-pass" name="password" class="input" type="password" autocomplete="new-password" placeholder="Min. 8 characters" minlength="8" required />
              </div>
              <div>
                <label class="label" for="reg-pass2">Confirm Password</label>
                <input id="reg-pass2" name="password_confirm" class="input" type="password" autocomplete="new-password" placeholder="Re-enter password" minlength="8" required />
              </div>
            </div>
            <div class="actions">
              <button class="btn btn-primary" type="submit">Create Account</button>
            </div>
          </div>
        </form>
      </div>
    </section>
  </main>
</body>
</html>


