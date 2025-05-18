<?php
session_start();

if (!isset($_SESSION['position']) || $_SESSION['position'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
require '../includes/connection.php';
?>