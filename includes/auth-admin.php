<?php
// Do NOT start session here. It should be started only once in index.php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
?>