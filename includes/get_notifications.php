<?php
include 'connection.php';

$today = date('Y-m-d');
$overdue_query = "
    SELECT b.name AS borrower_name, COUNT(bb.id) AS overdue_count
    FROM borrowed_books bb
    INNER JOIN borrowers b ON bb.borrower_id = b.id
    WHERE bb.return_date < ? 
    GROUP BY bb.borrower_id
";
$stmt = $conn->prepare($overdue_query);
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = [
        'name' => $row['borrower_name'],
        'count' => $row['overdue_count']
    ];
}
?>
