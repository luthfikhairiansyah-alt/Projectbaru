<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['level'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit;
}

// Arahkan ke dashboard yang sesuai berdasarkan level
if ($_SESSION['level'] === "superadmin") {
    header("Location: superadmin.php");
    exit;
} elseif ($_SESSION['level'] === "user") {
    header("Location: user.php");
    exit;
} else {
    // Jika level tidak dikenal, hapus sesi dan arahkan ke login
    session_destroy();
    header("Location: login.php");
    exit;
}
?>