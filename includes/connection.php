<?php
$host = getenv('DB_HOST');
$port = getenv('DB_PORT') ?: 3306;
$dbname = 'nwssu_lms_db';
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

$conn = new mysqli($host, $user, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
