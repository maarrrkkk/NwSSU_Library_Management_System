<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = $_POST["identifier"]; // Full name or email
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE full_name = ? OR email = ?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row["password"])) {
            echo "Login successful. Welcome " . $row["first_name"];
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}
?>
