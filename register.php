<link rel="stylesheet" href="assets/css/login_and_register.css">
<div class="register-container">
    <h2>Create Account</h2>
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
      <input type="email" name="email" placeholder="Email" required>
      <input name="phone" placeholder="Phone Number" required>
      <input name="university_id" placeholder="University ID" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Register</button>
    </form>
    <a class="login-link" href="login.php">Already have an account? Login here</a>
  </div>