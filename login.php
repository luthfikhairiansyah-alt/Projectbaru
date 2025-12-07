<?php
session_start();
include "koneksi.php";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // === CEK DI TABEL ANGGOTA ===
    $query_anggota = mysqli_query($conn, "SELECT * FROM anggota WHERE email='$email' AND password='$password'");
    $data_anggota = mysqli_fetch_array($query_anggota);
    $cek_anggota = mysqli_num_rows($query_anggota);

    if ($cek_anggota > 0) {
        // Simpan data ke session
        $_SESSION['id_user'] = $data_anggota['id_anggota']; // penting untuk user.php
        $_SESSION['nama'] = $data_anggota['nama_anggota'];
        $_SESSION['id_anggota'] = $data_anggota['id_anggota'];
        $_SESSION['level'] = 'user';

        header("Location: user.php");
        exit;
    } else {
        // === CEK DI TABEL ADMIN ===
        $query_admin = mysqli_query($conn, "SELECT * FROM admin WHERE email='$email' AND password='$password'");
        $data_admin = mysqli_fetch_array($query_admin);
        $cek_admin = mysqli_num_rows($query_admin);

        if ($cek_admin > 0) {
            $_SESSION['id_user'] = $data_admin['id_admin']; // opsional jika admin butuh ID
            $_SESSION['nama'] = $data_admin['nama_admin'];
            $_SESSION['level'] = 'superadmin';

            header("Location: superadmin.php");
            exit;
        } else {
            echo "<script>alert('❌ Email atau password salah!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Sistem Peminjaman Buku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card shadow">
          <div class="card-header bg-primary text-white text-center">
            <h5>Login Perpustakaan</h5>
          </div>
          <div class="card-body">
            <form method="POST">
              <div class="mb-3">
                <label>Email</label>
                <input type="text" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
