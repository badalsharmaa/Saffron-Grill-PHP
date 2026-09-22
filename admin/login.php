<?php
/**
 * Saffron Grill Admin - Staff Login
 */
require_once __DIR__ . '/includes/auth.php';

// If already logged in, redirect straight to admin dashboard
if (is_admin_logged_in()) {
    header('Location: /admin/index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (attempt_admin_login($username, $password)) {
        $redirect = $_SESSION['admin_login_redirect'] ?? '/admin/index.php';
        unset($_SESSION['admin_login_redirect']);
        if (empty($redirect) || strpos($redirect, 'login') !== false) {
            $redirect = '/admin/index.php';
        }
        header('Location: ' . $redirect);
        exit;
    } else {
        $error = 'Invalid username or password. Please try again.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff Login — Saffron Grill CRM</title>
<link rel="icon" type="image/png" href="<?= asset('emblem.png') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    background: radial-gradient(circle at top, #260e22, #0d040e);
    color: #fff;
    font-family: 'Inter', sans-serif;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }
  .login-card {
    background: rgba(28, 12, 27, 0.95);
    border: 1px solid rgba(234, 179, 8, 0.3);
    border-radius: 12px;
    padding: 36px;
    max-width: 400px;
    width: 100%;
    box-shadow: 0 20px 50px rgba(0,0,0,0.8);
    text-align: center;
  }
  .brand-logo { height: 48px; margin-bottom: 12px; }
  h1 { font-family: 'Cinzel', serif; font-size: 22px; color: #fff; margin-bottom: 6px; }
  p { font-size: 13px; color: #d1c4cb; margin-bottom: 24px; }
  .form-group { text-align: left; margin-bottom: 16px; }
  label { display: block; font-size: 12px; text-transform: uppercase; color: #e5e5e5; margin-bottom: 6px; letter-spacing: 0.05em; }
  input {
    width: 100%;
    padding: 11px 14px;
    background: rgba(0,0,0,0.4);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 6px;
    color: #fff;
    font-size: 14px;
  }
  input:focus { outline: none; border-color: #eab308; }
  button {
    width: 100%;
    padding: 12px;
    background: #eab308;
    color: #1a0818;
    border: none;
    border-radius: 6px;
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    margin-top: 10px;
    transition: background 0.2s;
  }
  button:hover { background: #f5d485; }
  .error-box {
    background: rgba(239, 68, 68, 0.2);
    border: 1px solid #ef4444;
    color: #fca5a5;
    padding: 10px;
    border-radius: 6px;
    font-size: 13px;
    margin-bottom: 16px;
  }
</style>
</head>
<body>

<div class="login-card">
  <img src="<?= asset('emblem.png') ?>" alt="Saffron Grill Logo" class="brand-logo">
  <h1>Saffron Portal</h1>
  <p>Enterprise CRM &amp; Management Dashboard</p>

  <?php if (!empty($error)): ?>
    <div class="error-box"><?= e($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="/admin/login.php" id="loginForm">
    <div class="form-group">
      <label for="username">Username / Email</label>
      <input type="text" name="username" id="username" required placeholder="Enter username or email" autocomplete="username">
    </div>
    <div class="form-group">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
        <label for="password" style="margin-bottom: 0;">Password</label>
        <span id="togglePass" style="font-size: 11px; color: #eab308; cursor: pointer; user-select: none;">Show</span>
      </div>
      <input type="password" name="password" id="password" required placeholder="••••••••••••" autocomplete="current-password" autofocus>
    </div>
    <button type="submit" style="cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
      <svg style="width: 15px; height: 15px; stroke-width: 2.2;" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
      Sign In to Dashboard
    </button>
  </form>
</div>

<script>
document.getElementById('togglePass').addEventListener('click', function() {
  var pass = document.getElementById('password');
  if (pass.type === 'password') {
    pass.type = 'text';
    this.textContent = 'Hide';
  } else {
    pass.type = 'password';
    this.textContent = 'Show';
  }
});
</script>

</body>
</html>
