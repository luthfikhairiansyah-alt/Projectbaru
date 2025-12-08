<?php
session_start();
// Pastikan koneksi.php mendefinisikan variabel $koneksi
include "koneksi.php";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Mengganti semua $conn menjadi $koneksi
    
    // === CEK DI TABEL ANGGOTA (USER) ===
    $stmt = $koneksi->prepare("SELECT * FROM anggota WHERE email = ? AND password = ?");
    $stmt->execute([$email, $password]);
    $data_anggota = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data_anggota) {
        $_SESSION['id_user'] = $data_anggota['id_anggota'];
        $_SESSION['nama'] = $data_anggota['nama_anggota'];
        $_SESSION['level'] = 'user';

        // Langsung arahkan ke dashboard user
        header("Location: user.php"); 
        exit;
    }

    // === CEK DI TABEL ADMIN (SUPERADMIN) ===
    $stmt = $koneksi->prepare("SELECT * FROM admin WHERE email = ? AND password = ?");
    $stmt->execute([$email, $password]);
    $data_admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data_admin) {
        $_SESSION['id_user'] = $data_admin['id_admin'];
        $_SESSION['nama'] = $data_admin['nama_admin'];
        $_SESSION['level'] = 'superadmin';

        // Langsung arahkan ke dashboard superadmin
        header("Location: superadmin.php"); 
        exit;
    }

    echo "<script>alert('❌ Email atau password salah!');</script>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - PerpustakaanKU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .login-container { max-width: 400px; padding: 15px; }
    </style>
</head>
<body>
    <div class="login-container w-100">
        <h3 class="text-center text-primary mb-4">Login Perpustakaan</h3>
        <div class="card shadow">
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Masuk</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>