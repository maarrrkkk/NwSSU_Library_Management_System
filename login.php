<?php
session_start();
$error = $_SESSION['login_error'] ?? '';
$previous_email = $_SESSION['previous_email'] ?? '';
unset($_SESSION['login_error'], $_SESSION['previous_email']);
include 'components/login&register_header.php';
?>

<link rel="stylesheet" href="assets/css/login_and_register.css">
<div class="login-container">
    <div class="login-box-container">
        <h2>Login</h2>
        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action="includes/process-login.php" method="POST">
            <input type="text" name="identifier" placeholder="Enter your email"
                   value="<?php echo htmlspecialchars($previous_email); ?>"
                   class="<?php echo $error ? 'error-input' : ''; ?>" required>

            <input type="password" name="password" placeholder="Password"
                   class="<?php echo $error ? 'error-input' : ''; ?>" required>

            <button type="submit">Login</button>
        </form>
    </div>
    <a class="register-link" href="register.php">Don't have an account? Register here</a>
</div>