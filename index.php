<?php
include 'components/header.php';
require 'includes/connection.php';

// Get all borrowers
$borrowersQuery = "SELECT * FROM borrowers";
$borrowersResult = $conn->query($borrowersQuery);

// Get all borrowed books and group them by borrower_id
$borrowedBooksQuery = "SELECT * FROM borrowed_books";
$borrowedBooksResult = $conn->query($borrowedBooksQuery);

$borrowedBooksByBorrower = [];
while ($book = $borrowedBooksResult->fetch_assoc()) {
    $borrowedBooksByBorrower[$book['borrower_id']][] = $book;
}
?>

<div class="home-section">
    <div class="table-list">
        <div class="lists-of-borrower" id="borrowerList">
            <div class="title-searc-box">
                <div class="logo-title-container">
                    <img src="assets/images/logo.png" alt="Logo" style="height: auto; width: 3rem;">
                    <h2>NwSSU LMS</h2>
                </div>
                <input type="text" id="searchBox" placeholder="Search borrower..." onkeyup="filterBorrowers()" />
            </div>
            <h2 style="margin-bottom: 1rem;">Borrower List</h2>
            <div class="scrollable-borrower-list">
                <ul id="borrowerUl">
                    <?php
                    $counter = 1;
                    while ($borrower = $borrowersResult->fetch_assoc()): ?>
                        <li onclick='showDetails(<?= json_encode($borrower) ?>, <?= json_encode($borrowedBooksByBorrower[$borrower["id"]] ?? []) ?>)'>
                            <?= $counter++ . ". " . htmlspecialchars($borrower['name']) ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
        <div class="borrower-details" id="borrowerDetails"></div>
    </div>
</div>

<?php include 'components/footer.php'; ?>

<script>
    function showDetails(borrower, books) {
        const details = document.getElementById('borrowerDetails');
        const borrowerList = document.getElementById('borrowerList');

        const today = new Date().toISOString().split('T')[0];

        let booksHTML = '';
        books.forEach(book => {
            const overdue = book.return_date < today ? '<span class="book-overdue">Overdue</span>' : '';
            booksHTML += `
                <div class="book-item">
                    <div class="title-indicator">
                        <div class="book-title">${book.book_title}</div>
                        <div class="book-actions">
                            ${overdue}
                        </div>
                    </div>
                    <div class="book-meta">
                        <span>Book ID: ${book.book_id}</span>
                        <div class="date-borrowed">
                            <span>Borrowed: ${book.borrow_date}</span>
                            <span>Return: ${book.return_date}</span>
                        </div>
                    </div>
                </div>
            `;
        });

        details.innerHTML = `
        <div class="details-container">
            <div class="navigation-back">
                <a href="#" onclick="hideDetails()" class="back-button">✖</a>
            </div>
            <h1>${borrower.name}</h1>
            <p><strong>Age:</strong> ${borrower.age}</p>
            <p><strong>Status:</strong> ${borrower.status}</p>
            <p><strong>Email:</strong> ${borrower.email}</p>
            <p><strong>Books Borrowed:</strong> ${borrower.number_of_books}</p>
            <div class="borrowed-books">
                ${booksHTML || "<p>No books borrowed.</p>"}
            </div>
        </div>
    `;

        details.classList.add('visible');
        borrowerList.classList.add('shrink');
    }

    function hideDetails() {
        document.getElementById('borrowerDetails').classList.remove('visible');
        document.getElementById('borrowerList').classList.remove('shrink');
    }

    function filterBorrowers() {
        const input = document.getElementById('searchBox');
        const filter = input.value.toLowerCase();
        const ul = document.getElementById('borrowerUl');
        const li = ul.getElementsByTagName('li');

        for (let i = 0; i < li.length; i++) {
            const txtValue = li[i].textContent || li[i].innerText;
            li[i].style.display = txtValue.toLowerCase().includes(filter) ? "" : "none";
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            hideDetails();
        }
    });
</script>