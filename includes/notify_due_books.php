<?php
require 'connection.php'; // Include your database connection
require 'send_email.php';    // Your sendEmail() function or PHPMailer setup

$today = date('Y-m-d');

// Get all borrowed books where the return date is today or past
$sql = "SELECT bb.*, b.email, b.name 
        FROM borrowed_books bb
        JOIN borrowers b ON bb.borrower_id = b.id
        WHERE return_date <= ? AND bb.return_status IS NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $borrowed_name = $row['name'];
    $book_title = $row['book_title'];
    $borrow_date = $row['borrow_date'];
    $return_date = $row['return_date'];
    $email = $row['email'];

    // Determine if it's due today or overdue
    $todayDate = new DateTime($today);
    $returnDate = new DateTime($return_date);

    if ($todayDate == $returnDate) {
        $subject = "Library Book Due Today Reminder";
        $message = "
            <p>Dear {$borrowed_name},</p>
            <p>This is a reminder that the book <b>{$book_title}</b> is due <b>today ({$return_date})</b>.</p>
            <p>Please return it on time to avoid penalties.</p>
            <p>Thank you,<br>Library Management</p>
        ";
    } elseif ($todayDate > $returnDate) {
        $subject = "Library Book Overdue Notice";
        $message = "
            <p>Dear {$borrowed_name},</p>
            <p>The book <b>{$book_title}</b> was due on <b>{$return_date}</b> and is now overdue.</p>
            <p>Please return it immediately to avoid further penalties.</p>
            <p>Thank you,<br>Library Management</p>
        ";
    } else {
        continue; // Skip books that aren't due/overdue
    }

    // Send the email
    sendEmail($email, $subject, $message);
}

echo "Notification process completed.";
?>
