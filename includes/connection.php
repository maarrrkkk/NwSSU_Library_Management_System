<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "nwssu_lms_db";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
