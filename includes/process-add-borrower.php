<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name       = trim($_POST['name']);
    $age        = $_POST['age'];
    $status     = $_POST['status'];
    $student_id = isset($_POST['student_id']) ? trim($_POST['student_id']) : null;
    $teacher_id = isset($_POST['teacher_id']) ? trim($_POST['teacher_id']) : null;
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];

    // Check if borrower already exists
    $checkQuery = "SELECT * FROM borrowers WHERE name = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "exists", "message" => "❗ Borrower already exists"]);
        exit;
    }

    // Proceed to insert
    $insertQuery = "INSERT INTO borrowers (name, age, status, student_id, teacher_id, email, phone, number_of_books) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sisssss", $name, $age, $status, $student_id, $teacher_id, $email, $phone);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "✅ Borrower added successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "❌ Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
