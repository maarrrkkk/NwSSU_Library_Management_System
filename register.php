<?php
include 'components/login&register_header.php';

// Helper for error highlighting
function showInputError($name) {
    if (isset($_GET['error']) && $_GET['error'] === 'exists') {
        if (isset($_GET['field']) && strpos($_GET['field'], $name) !== false) {
            return 'input-error';
        }
    }
    return '';
}
?>

<link rel="stylesheet" href="assets/css/login_and_register.css">
<div class="register-container">
    <h2>Create Account</h2>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'exists'): ?>
        <div class="register-error-message" style="color: red; margin-bottom: 10px;">
            Email, phone number, or university ID already exists.
        </div>
    <?php elseif (isset($_GET['error']) && $_GET['error'] === 'server'): ?>
        <div class="register-error-message" style="color: red; margin-bottom: 10px;">
            Something went wrong. Please try again.
        </div>
    <?php endif; ?>

    <form action="includes/process-register.php" method="POST">
      <input name="first_name" placeholder="First Name" required>
      <input name="middle_name" placeholder="Middle Name" required>
      <input name="surname" placeholder="Surname" required>
      <input type="number" name="age" placeholder="Age" required>
      <select name="position" required>
        <option value="">Select Position</option>
        <option value="admin">Admin</option>
        <option value="librarian assistant">Librarian Assistant</option>
      </select>
      <input type="email" name="email" placeholder="Email" required class="<?= showInputError('email') ?>">
      <input name="phone" placeholder="Phone Number" required class="<?= showInputError('phone') ?>">
      <input name="university_id" placeholder="University ID" required class="<?= showInputError('id') ?>">
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Register</button>
    </form>
    <a class="login-link" href="login.php">Already have an account? Login here</a>
</div>
