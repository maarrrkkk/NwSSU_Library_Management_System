<?php
require_once 'components/header.php';
?>

<div class="item">

    <div class="main-content">
        <?php require_once 'components/profile.php'; ?>

        <div class="navigation-back">
            <a href="index.php" class="back-button">← Back</a>
            <h1>Borrower</h1>
        </div>

        <?php
        include './includes/connection.php';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // DELETE BORROWER
            if (isset($_POST['delete_borrower_id'])) {
                $delete_borrower_id = intval($_POST['delete_borrower_id']);

                // Delete all borrowed books first (to maintain foreign key constraints)
                $stmtDeleteBooks = $conn->prepare("DELETE FROM borrowed_books WHERE borrower_id = ?");
                $stmtDeleteBooks->bind_param("i", $delete_borrower_id);
                $stmtDeleteBooks->execute();

                // Then delete the borrower
                $stmtDeleteBorrower = $conn->prepare("DELETE FROM borrowers WHERE id = ?");
                $stmtDeleteBorrower->bind_param("i", $delete_borrower_id);
                $stmtDeleteBorrower->execute();

                // Redirect to borrower list or main page after deletion
                header("Location: index.php");
                exit;
            }


            // DELETE BOOK
            if (isset($_POST['delete_book_id'])) {
                $delete_book_id = intval($_POST['delete_book_id']);
        
                // Get borrower ID before deletion
                $stmtGetBorrower = $conn->prepare("SELECT borrower_id FROM borrowed_books WHERE id = ?");
                $stmtGetBorrower->bind_param("i", $delete_book_id);
                $stmtGetBorrower->execute();
                $result = $stmtGetBorrower->get_result();
                $bookData = $result->fetch_assoc();
        
                if ($bookData) {
                    $borrower_id = $bookData['borrower_id'];
        
                    // Delete the book record
                    $stmtDelete = $conn->prepare("DELETE FROM borrowed_books WHERE id = ?");
                    $stmtDelete->bind_param("i", $delete_book_id);
                    $stmtDelete->execute();
        
                    // Decrement number_of_books
                    $stmtUpdateCount = $conn->prepare("UPDATE borrowers SET number_of_books = number_of_books - 1 WHERE id = ?");
                    $stmtUpdateCount->bind_param("i", $borrower_id);
                    $stmtUpdateCount->execute();
        
                    // Redirect back
                    header("Location: borrower.php?id=" . $borrower_id);
                    exit;
                }
            }
        
            // ADD BOOK
            if (isset($_POST['borrower_id']) && isset($_POST['book_title']) && isset($_POST['book_id']) && isset($_POST['borrow_date']) && isset($_POST['return_date'])) {
                $borrower_id = intval($_POST['borrower_id']);
                $book_title = $_POST['book_title'];
                $book_id = $_POST['book_id'];
                $borrow_date = $_POST['borrow_date'];
                $return_date = $_POST['return_date'];

                // Check if the book already exists in borrowed_books
                $checkStmt = $conn->prepare("SELECT id FROM borrowed_books WHERE book_id = ?");
                $checkStmt->bind_param("s", $book_id);
                $checkStmt->execute();
                $checkResult = $checkStmt->get_result();

                if ($checkResult->num_rows > 0) {
                    // Display the message in the page
                    $error_message = "The book is already borrowed";
                } else {
                    // Proceed with adding the book
                    // Fetch borrower's name
                    $stmtName = $conn->prepare("SELECT name FROM borrowers WHERE id = ?");
                    $stmtName->bind_param("i", $borrower_id);
                    $stmtName->execute();
                    $borrowerData = $stmtName->get_result()->fetch_assoc();
                    $borrowed_name = $borrowerData['name'];

                    // Insert book
                    $insertStmt = $conn->prepare("INSERT INTO borrowed_books (borrower_id, borrowed_name, book_id, book_title, borrow_date, return_date) VALUES (?, ?, ?, ?, ?, ?)");
                    $insertStmt->bind_param("isssss", $borrower_id, $borrowed_name, $book_id, $book_title, $borrow_date, $return_date);
                    $insertStmt->execute();

                    // Increment number_of_books
                    $updateStmt = $conn->prepare("UPDATE borrowers SET number_of_books = number_of_books + 1 WHERE id = ?");
                    $updateStmt->bind_param("i", $borrower_id);
                    $updateStmt->execute();

                    header("Location: borrower.php?id=" . $borrower_id);
                    exit;
                }
            }
        }
        

        if (isset($_GET['id'])) {
            $borrower_id = intval($_GET['id']);

            // Fetch borrower info
            $stmt = $conn->prepare("SELECT * FROM borrowers WHERE id = ?");
            $stmt->bind_param("i", $borrower_id);
            $stmt->execute();
            $borrower = $stmt->get_result()->fetch_assoc();

            // Fetch borrowed books
            $bookStmt = $conn->prepare("SELECT * FROM borrowed_books WHERE borrower_id = ?");
            $bookStmt->bind_param("i", $borrower_id);
            $bookStmt->execute();
            $books = $bookStmt->get_result();
        } else {
            echo "No borrower selected.";
            exit;
        }
        ?>

        <?php if (isset($error_message)): ?>
            <div id="errorMessage" class="error-message" style="color: red; background-color: #f8d7da; padding: 10px; border-radius: 5px; margin-top: 1rem;">
                <?php echo htmlspecialchars($error_message); ?>
            </div>

            <script>
                setTimeout(function() {
                    const errorBox = document.getElementById('errorMessage');
                    if (errorBox) {
                        errorBox.style.display = 'none';
                    }
                }, 5000); // 5000ms = 5 seconds
            </script>
        <?php endif; ?>


        <div class="borrower-details">
            <div class="borrower-info">
                <div class="name"><?= htmlspecialchars($borrower['name']) ?></div>
                <div class="meta">
                    <span>Age: <?= $borrower['age'] ?></span>
                    <span>
                        Student ID: 
                        <?= !empty($borrower['student_id']) ? htmlspecialchars($borrower['student_id']) : 'N/A' ?>
                    </span>
                    <span>
                        Status: 
                        <?= (!empty($borrower['student_id']) && strtolower($borrower['status']) === 'student') 
                            ? 'Student' 
                            : 'Non-student' ?>
                    </span>
                </div>
            </div>


            <div class="borrowed-books">
                <?php while ($book = $books->fetch_assoc()): ?>
                    <div class="book-item">
                        <div class="title-indicator">
                            <div class="book-title"><?= htmlspecialchars($book['book_title']) ?></div>
                            <div class="book-actions">
                                <?php
                                $today = date('Y-m-d');
                                $overdue = ($book['return_date'] < $today) ? 'Overdue' : '';
                                ?>
                                <span class="book-overdue"><?= $overdue ?></span>
                                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');" style="display:inline;">
                                    <input type="hidden" name="delete_book_id" value="<?= $book['id'] ?>">
                                    <button class="delete-book-button" title="Delete Book" type="submit">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="book-meta">
                            <span>Book ID: <?= htmlspecialchars($book['book_id']) ?></span>
                            <div class="date-borrowed">
                                <span>Borrowed: <?= $book['borrow_date'] ?></span>
                                <span>Return: <?= $book['return_date'] ?></span>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="borrowed-details-action">
                <button class="add-book-button" onclick="showAddBookModal(<?= $borrower['id'] ?>)">+ Add Book</button>
                <form method="POST" onsubmit="return confirm('Are you sure you want to delete this borrower? This will also delete all borrowed book records.');" style="display:inline;">
                    <input type="hidden" name="delete_borrower_id" value="<?= $borrower['id'] ?>">
                    <button class="delete-borrower-button" type="submit">Delete Borrower</button>
                </form>                <?php 
                // Make $borrower_id available in modal
                $currentBorrowerId = $borrower['id']; 
                require 'components/add-book-modal.php'; 
                ?>
            </div>
        </div>
    </div>

    <?php require_once 'components/footer.php'; ?>
</div>

<script>
function showAddBookModal(borrowerId) {
    document.getElementById('addBookModalOverlay').style.display = 'block';
    document.getElementById('borrowerIdInput').value = borrowerId;
}

document.getElementById('closeAddBookModal').addEventListener('click', function () {
    document.getElementById('addBookModalOverlay').style.display = 'none';
});
</script>
