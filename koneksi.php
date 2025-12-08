<?php
$servername = getenv('DB_HOST') ?: 'mysql';
$username   = getenv('DB_USER') ?: 'libuser';
$password   = getenv('DB_PASS') ?: 'libpass';
$dbname     = getenv('DB_NAME') ?: 'db_library';

try {
    $koneksi = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>