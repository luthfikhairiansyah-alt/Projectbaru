<?php
function getConnetion() {
$servername = getenv('DB_HOST') ?: 'mysql';
$username   = getenv('DB_USER') ?: 'root';
$password   = getenv('DB_PASSWORD') ?: 'rootpass';
$dbname     = getenv('DB_NAME') ?: 'library';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
}
?>