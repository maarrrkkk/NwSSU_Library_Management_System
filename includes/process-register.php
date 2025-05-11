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

    $stmt = $conn->prepare("INSERT INTO users (first_name, middle_name, surname, full_name, age, position, email, phone, university_id, password)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisssss", $first_name, $middle_name, $surname, $full_name, $age, $position, $email, $phone, $university_id, $password);

    if ($stmt->execute()) {
        echo "Registration successful.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
