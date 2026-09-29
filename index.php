<?php
require_once __DIR__ . '/config.php';

if (isLoggedIn()) {
    redirect('home.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Please enter your email and password.';
    } else {
        $users = getUsers();
        $user = null;
        foreach ($users as $entry) {
            if (($entry['email'] ?? '') === $email && ($entry['password'] ?? '') === $password) {
                $user = $entry;
                break;
            }
        }

        if ($user) {
            $_SESSION['user'] = $user;
            redirect('home.php');
        } else {
            $error = 'Invalid email or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>StyliCycle - Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="auth-login-page">
  <div class="auth-shell">
    <aside class="auth-visual" aria-label="Wedding gown showcase"></aside>

    <main class="auth-panel">
      <div class="auth-card">
        <div class="brand-row">
          <div class="brand-mark">K</div>
          <div class="brand-name">StyliCycle</div>
        </div>

        <h1>Welcome back</h1>
        <p class="subtitle">Sign in to rent, list, and manage your event wardrobe.</p>

        <?php if ($error !== ''): ?>
          <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form id="loginForm" method="post" action="index.php">
          <input type="hidden" name="login" value="1">
          <label class="field-group">
            <span>Email</span>
            <input type="email" id="email" name="email" placeholder="you@example.com" required>
          </label>

          <label class="field-group">
            <span>Password</span>
            <input type="password" id="password" name="password" placeholder="Your password" required>
          </label>

          <input type="checkbox" id="agreeTermsLogin" class="sr-only" checked>

          <button type="submit" class="primary-button">Continue</button>
        </form>

        <p class="signup-link">
          New to StyliCycle? <a href="signup.php">Create an account</a>
        </p>
      </div>
    </main>
  </div>

  <script src="script.js"></script>
</body>
</html>
