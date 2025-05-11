<?php
include './includes/connection.php';
include './includes/get_notifications.php';
?>

<div class="profile-container">
    <div class="profile-header">
        <h2><span style="font-weight: 100;">Hello</span> Emely Taduyo!</h2>
        <div class="notification-container">
            <i class="fa-solid fa-bell bell-icon" onclick="toggleNotifications()"></i>
            <?php if (!empty($notifications)): ?>
                <span class="notification-dot"></span>
            <?php endif; ?>
            <div class="notification-dropdown" id="notificationDropdown">
                <p><strong>Notifications</strong></p>
                <ul>
                    <?php if (!empty($notifications)): ?>
                        <?php foreach ($notifications as $note): ?>
                            <li>📚 <strong><?= htmlspecialchars($note['name']) ?></strong> has
                                <?= $note['count'] > 1 ? $note['count'] . ' overdue books' : 'an overdue book' ?>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>No overdue books</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleNotifications() {
        const dropdown = document.getElementById("notificationDropdown");
        dropdown.style.display =
            dropdown.style.display === "block" ? "none" : "block";
    }
</script>
