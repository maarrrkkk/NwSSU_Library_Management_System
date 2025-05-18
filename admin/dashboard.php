<?php
session_start();

if (!isset($_SESSION['position']) || $_SESSION['position'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

include 'components/header.php';
require '../includes/connection.php';
?>

<div class="item">
    <div class="main-content">
        <?php require_once 'components/profile.php'; ?>
        <div class="list-section">
            <div class="top-list">
                <div class="search-container">
                    <i class="fas fa-search"></i>
                    <input type="text" class="search-input" id="borrowerSearch" placeholder="Search borrower...">                
                </div>                
                <button class="add-button" id="openModal">+ Add Borrower</button>
                <?php require_once 'components/add-borrower-modal.php'; ?>
            </div>

            <div class="list-container" id="borrowerList">
            <?php
            $query = "SELECT * FROM borrowers";
            $result = $conn->query($query);

            while ($row = $result->fetch_assoc()) {
                $borrowerId = $row['id'];
                $borrowerName = $conn->real_escape_string($row['name']);
                $status = ucfirst($row['status']);
                $studentId = $row['student_id'] ?: 'N/A';
                $bookCount = $row['number_of_books'] . ' book' . ($row['number_of_books'] != 1 ? 's' : '');

                $today = date('Y-m-d');
                $overdueQuery = "SELECT COUNT(*) as overdue_count FROM borrowed_books 
                                WHERE borrowed_name = '{$borrowerName}' AND return_date < '{$today}'";
                $overdueResult = $conn->query($overdueQuery);
                $overdueData = $overdueResult->fetch_assoc();
                $isOverdue = $overdueData['overdue_count'] > 0;

                $overdueClass = $isOverdue ? 'overdue' : '';

                echo "
                <a href='borrower.php?id={$borrowerId}' class='list-link'>
                    <div class='list-item {$overdueClass}' data-id='{$borrowerId}'>
                        <div class='list-info'>
                            <div class='name'>{$row['name']}</div>
                            <div class='details'>
                                <span class='student-indicator'><b>{$status}</b></span>
                                <span class='student-id'>{$studentId}</span>
                                <span class='book-count'>{$bookCount}</span>
                            </div>
                        </div>
                        <div class='actions'>
                            <button class='icon delete' title='Delete' onclick='event.stopPropagation(); deleteBorrower(event, {$borrowerId})'></button>
                           
                        </div>
                    </div>
                </a>";
                }
            ?>
            </div>
        </div>
    </div>


<?php require_once 'components/footer.php'; ?>
