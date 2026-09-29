<?php
require_once __DIR__ . '/config.php';

if (isLoggedIn()) {
    redirect('home.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $firstName = trim($_POST['firstName'] ?? '');
    $middleName = trim($_POST['middleName'] ?? '');
    $lastName = trim($_POST['lastName'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $agreeTerms = !empty($_POST['agreeTermsSignup']);

    if (!$agreeTerms) {
        $error = 'You must agree to the Terms and Conditions to register.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } elseif ($firstName === '' || $lastName === '' || $email === '' || $age === '') {
        $error = 'Please fill in all required fields.';
    } else {
        $users = getUsers();
        foreach ($users as $user) {
            if (($user['email'] ?? '') === $email) {
                $error = 'This email is already registered.';
                break;
            }
        }

        if ($error === '') {
            $newUser = [
                'firstName' => $firstName,
                'middleName' => $middleName,
                'lastName' => $lastName,
                'age' => (int)$age,
                'email' => $email,
                'password' => $password,
                'twoFactorEnabled' => false
            ];
            $users[] = $newUser;
            saveUsers($users);
            $_SESSION['user'] = $newUser;
            redirect('home.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Account - StyliCycle</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
  <nav class="top-nav"></nav>
  <div class="container">
    <div class="auth-header">
      <h2>Create Account</h2>
      <p>Set up your partnership profile and start listing rentals with confidence.</p>
    </div>

    <?php if ($error !== ''): ?>
      <p class="error-message"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form id="registerForm" method="post" action="signup.php">
      <input type="hidden" name="register" value="1">
      <input type="text" name="firstName" id="firstName" placeholder="First Name" required>
      <input type="text" name="middleName" id="middleName" placeholder="Middle Name">
      <input type="text" name="lastName" id="lastName" placeholder="Last Name" required>
      <input type="number" name="age" id="age" placeholder="Age" required>
      <input type="email" name="email" id="email" placeholder="Email" required>
      <input type="password" name="password" id="password" placeholder="Password" required>
      <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" required>
      <div class="terms-section">
        <div class="terms-box">
          <h3>Terms & Conditions</h3>
          <ol>
            <li>By accessing or using the StyliCycle platform, you agree to comply with these Terms and Conditions.</li>
            <li>Users must provide accurate information when creating an account and keep login credentials confidential.</li>
            <li>Items must be safe, accurately described, and rented through the platform’s secure system.</li>
            <li>Illegal, hazardous, or counterfeit items are prohibited and abuse may lead to account suspension.</li>
            <li>Payments are processed securely; refunds follow platform policies and StyliCycle may mediate disputes.</li>
            <li>StyliCycle provides the platform “as is” and is not liable for item condition or safety.</li>
            <li>Personal data is processed under applicable privacy laws and only to facilitate transactions and services.</li>
            <li>StyliCycle may suspend or terminate accounts that violate these Terms; users may delete accounts anytime.</li>
          </ol>
        </div>
        <label class="terms-checkbox"><input type="checkbox" id="agreeTermsSignup" name="agreeTermsSignup" required> I agree to the Terms and Conditions</label>
      </div>
      <button type="submit" class="primary-button">Register</button>
      <div class="form-actions">
        <button type="button" class="secondary-button" onclick="showToast('Social sign-up coming soon!')">Sign up with Google</button>
        <button type="button" class="secondary-button" onclick="location.href='index.php'">Back to Login</button>
      </div>
      <p><a href="index.php">Already have an account? Log in</a></p>
    </form>
    <div id="twoFactorSetup" style="display: none;">
      <h3>Two-Factor Authentication Setup</h3>
      <p>A verification code has been sent to your email. Please enter it below to complete registration.</p>
      <input type="text" id="twoFactorCode" placeholder="Enter 6-digit code" maxlength="6" required>
      <button id="verifyCodeBtn" class="primary-button">Verify Code</button>
      <button id="resendCodeBtn" class="secondary-button">Resend Code</button>
    </div>
  </div>
  <script src="script.js"></script>
</body>
</html>
