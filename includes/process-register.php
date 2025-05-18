<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $middle_name = $_POST["middle_name"];
    $surname = $_POST["surname"];
    $full_name = $first_name . ' ' . $middle_name . ' ' . $surname;
    $age = $_POST["age"];
    $position = $_POST["position"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $university_id = $_POST["university_id"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    // Check for duplicate credentials
    $check = $conn->prepare("SELECT * FROM users WHERE email = ? OR phone = ? OR university_id = ?");
    $check->bind_param("sss", $email, $phone, $university_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        header("Location: ../register.php?error=exists");
        exit();
    } else {
        $stmt = $conn->prepare("INSERT INTO users (first_name, middle_name, surname, full_name, age, position, email, phone, university_id, password)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssisssss", $first_name, $middle_name, $surname, $full_name, $age, $position, $email, $phone, $university_id, $password);

        if ($stmt->execute()) {
            header("Location: ../login.php?registered=success");
        } else {
            header("Location: ../register.php?error=server");
        }
    }

    $check->close();
    $stmt->close();
    $conn->close();
}
?>
