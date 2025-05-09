<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name       = $_POST['name'];
    $age        = $_POST['age'];
    $status     = $_POST['status'];
    $student_id = $_POST['student_id'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];

    $stmt = $conn->prepare("INSERT INTO borrowers (name, age, status, student_id, email, phone)
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissss", $name, $age, $status, $student_id, $email, $phone);

    if ($stmt->execute()) {
        echo "✅ Borrower added successfully";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
