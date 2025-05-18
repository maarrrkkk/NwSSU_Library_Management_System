<?php
session_start();
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim(strtolower($_POST["identifier"]));
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE LOWER(email) = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $_SESSION['previous_email'] = $email;

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["position"] = $row["position"];
            $_SESSION['first_name'] = $row['first_name'];
            unset($_SESSION['login_error'], $_SESSION['previous_email']);

            // 🔥 Redirect based on position
            if ($_SESSION['position'] === 'admin') {
                header("Location: ../admin/dashboard.php");
                exit;
            } else {
                $_SESSION['login_error'] = "Unauthorized position.";
                header("Location: ../login.php");
                exit;
            }
        } else {
            $_SESSION['login_error'] = "Incorrect password.";
            header("Location: ../login.php");
            exit;
        }
    } else {
        $_SESSION['login_error'] = "Incorrect Email.";
        header("Location: ../login.php");
        exit;
    }
}
?>
