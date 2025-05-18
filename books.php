<?php
include 'components/header.php';
require 'includes/connection.php';

// Fetch all books from the borrowed_books table
$booksQuery = "SELECT * FROM borrowed_books";
$booksResult = $conn->query($booksQuery);
?>

<div class="home-section">
    <div class="table-list">
        <div class="lists-of-books">
            <div class="title-searc-box">
                <div class="logo-title-container">
                    <img src="assets/images/logo.png" alt="Logo" style="height: auto; width: 3rem;">
                    <h2>NwSSU LMS</h2>
                </div>
                <input type="text" id="searchBookBox" placeholder="Search book..." onkeyup="filterBooks()" />
            </div>
            <h2 style="margin-bottom: 1rem;">Book List</h2>
            <div class="scrollable-book-list">
                <ul id="bookUl">
                    <?php
                    $counter = 1;
                    while ($book = $booksResult->fetch_assoc()): ?>
                        <li class="book-item">
                            <h2 style="margin-bottom: 1rem;"><?= $counter++ . ". " . htmlspecialchars($book['book_title']) ?></h2>
                            <div class="book-meta-flex">
                                <span><strong>Book ID:</strong> <?= htmlspecialchars($book['book_id']) ?></span><br>
                                <span><strong>Borrow Date:</strong> <?= htmlspecialchars($book['borrow_date']) ?></span><br>
                                <span><strong>Return Date:</strong> <?= htmlspecialchars($book['return_date']) ?></span>
                            </div>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include 'components/footer.php'; ?>

<script>
function filterBooks() {
    const input = document.getElementById('searchBookBox');
    const filter = input.value.toLowerCase();
    const ul = document.getElementById('bookUl');
    const li = ul.getElementsByTagName('li');

    for (let i = 0; i < li.length; i++) {
        const txtValue = li[i].textContent || li[i].innerText;
        li[i].style.display = txtValue.toLowerCase().includes(filter) ? "" : "none";
    }
}
</script>
