<?php
function getConnetion() {
$servername = getenv('DB_HOST') ?: 'mysql';
$username   = getenv('DB_USER') ?: 'root';
$password   = getenv('DB_PASSWORD') ?: '1234';
$dbname     = getenv('DB_NAME') ?: 'db_library';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
}
?>
