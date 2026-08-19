<?php
require_once __DIR__ . '/config.php';

// Already logged in? go to dashboard
if (!empty($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Username and password are required.';
    } else {
        $stmt = db()->prepare('SELECT id, username, password_hash FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = (int)$user['id'];
            $_SESSION['admin_username'] = $user['username'];
            header('Location: index.php');
            exit;
        }
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login — Google Mart Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body{min-height:100vh;display:flex;align-items:center;justify-content:center;background:#1e1b4b}
  .card{width:100%;max-width:380px;border:0;border-radius:14px}
</style>
</head>
<body>
<div class="card shadow-lg p-4">
  <div class="text-center mb-3">
    <div class="fw-bold fs-4">Google Mart</div>
    <div class="text-secondary small">Admin Panel Login</div>
  </div>
  <?php if ($error): ?>
    <div class="alert alert-danger py-2 small"><?= e($error) ?></div>
  <?php endif; ?>
  <form method="post">
    <div class="mb-3">
      <label class="form-label small fw-semibold">Username</label>
      <input class="form-control" name="username" required autofocus>
    </div>
    <div class="mb-3">
      <label class="form-label small fw-semibold">Password</label>
      <input type="password" class="form-control" name="password" required>
    </div>
    <button class="btn btn-primary w-100">Login</button>
  </form>
  <div class="text-center small text-secondary mt-3">Default: <code>admin</code> / <code>admin123</code></div>
</div>
</body>
</html>
