<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$adminFirstName = isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name']) : 'Admin';

// Get the current page name, e.g., 'dashboard.php' or 'borrower.php'
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<div class="container">
    <div class="navigation-container">
        <div class="sidebar">
            <div class="logo-container">
                <a href="#">
                    <img class="img-logo" src="../assets/images/logo.png" alt="NwSSU Logo">
                    <span class="logo-text">NwSSU LMS</span>
                </a>
            </div>

            <div class="menu-section">
                <nav class="side-links">
                    <a href="dashboard.php" class="<?= ($currentPage === 'dashboard.php' || $currentPage === 'borrower.php') ? 'active' : '' ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <!-- <a href="#" class="<?= $currentPage === '#' ? 'active' : '' ?>">
                        <i class="fas fa-user"></i> Profile
                    </a>
                    <a href="settings.php" class="<?= $currentPage === 'settings.php' ? 'active' : '' ?>">
                        <i class="fas fa-cog"></i> Settings
                    </a> -->
                </nav>
            </div>

            <div class="logout-section">
                <a href="./../includes/process-logout.php" class="logout_button">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

