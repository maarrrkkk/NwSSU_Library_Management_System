<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="navbar-container">
    <nav class="navbar">
        <ul class="nav-list">
            <li>
                <a href="index.php" class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">
                    <i class="fas fa-users"></i> Borrowers
                </a>
            </li>
            <li>
                <a href="books.php" class="<?= $currentPage === 'books.php' ? 'active' : '' ?>">
                    <i class="fas fa-book"></i> Books
                </a>
            </li>
        </ul>
        <ul class="nav-list">
            <li>
                <a href="login.php" class="<?= $currentPage === 'login.php' ? 'active' : '' ?>">
                    <i class="fas fa-user"></i> Admin
                </a>
            </li>
        </ul>
    </nav>
</div>
