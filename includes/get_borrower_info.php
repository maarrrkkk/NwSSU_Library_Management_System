<?php
require 'connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT phone, email FROM borrowers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($phone, $email);
    $stmt->fetch();
    echo json_encode(['phone' => $phone, 'email' => $email]);
    $stmt->close();
}
?>