<link rel="stylesheet" href="assets/css/login_and_register.css">
<div class="login-container">
    <div class="login-box-container">
        <h2>Login</h2>
        <form action="includes/process-login.php" method="POST">
            <input type="text" name="identifier" placeholder="Full Name or Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
    <a class="register-link" href="register.php">Don't have an account? Register here</a>
</div>