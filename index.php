<?php
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] != "superadmin") {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin - PerpustakaanKU</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">📚 PerpustakaanKU</a>
      <div class="d-flex">
        <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
      </div>
    </div>
  </nav>

  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-2 bg-light vh-100 p-3 border-end">
        <h5 class="text-center">Menu</h5>
        <ul class="nav flex-column">
          <li class="nav-item"><a class="nav-link" href="#anggota">👥 Data Anggota</a></li>
          <li class="nav-item"><a class="nav-link" href="#admin">🧑‍💼 Data Admin</a></li>
          <li class="nav-item"><a class="nav-link" href="#buku">📘 Data Buku</a></li>
          <li class="nav-item"><a class="nav-link" href="#riwayat">📜 Riwayat Peminjaman</a></li>
          <li class="nav-item"><a class="nav-link" href="#scan">🔍 Scan Buku</a></li>
        </ul>
      </div>

      <!-- Main Content -->
      <div class="col-md-10 p-4">
        <h2 class="mb-4 text-primary">Dashboard Admin</h2>

        <!-- Data Anggota -->
        <section id="anggota" class="mb-5">
          <h4>👥 Data Anggota</h4>
          <table class="table table-bordered table-striped">
            <thead class="table-primary">
              <tr><th>Nama</th><th>ID Perpustakaan</th><th>Alamat</th></tr>
            </thead>
            <tbody>
              <tr><td>Ryan Kai</td><td>AG001</td><td>Jl. Merdeka No.1</td></tr>
              <tr><td>Sinta Ayu</td><td>AG002</td><td>Jl. Melati No.3</td></tr>
              <tr><td>Andi Wijaya</td><td>AG003</td><td>Jl. Mawar No.5</td></tr>
              <tr><td>Dewi Rahayu</td><td>AG004</td><td>Jl. Cemara No.9</td></tr>
              <tr><td>Budi Santoso</td><td>AG005</td><td>Jl. Anggrek No.11</td></tr>
            </tbody>
          </table>
        </section>

        <!-- Data Admin -->
        <section id="admin" class="mb-5">
          <h4>🧑‍💼 Data Admin</h4>
          <table class="table table-bordered table-striped">
            <thead class="table-success">
              <tr><th>Nama</th><th>Email</th><th>No Telp</th><th>ID Perpustakaan</th></tr>
            </thead>
            <tbody>
              <tr><td>Admin Utama</td><td>utama@perpus.id</td><td>08123456789</td><td>AD001</td></tr>
              <tr><td>Admin Kedua</td><td>kedua@perpus.id</td><td>08987654321</td><td>AD002</td></tr>
            </tbody>
          </table>
        </section>

        <!-- Data Buku -->
        <section id="buku" class="mb-5">
          <h4>📘 Data Buku</h4>
          <table class="table table-bordered table-striped">
            <thead class="table-info">
              <tr><th>Judul Buku</th><th>Tanggal Terbit</th><th>Penerbit</th><th>Jumlah Halaman</th><th>Jenis Buku</th></tr>
            </thead>
            <tbody>
              <tr><td>Belajar PHP Dasar</td><td>12-01-2020</td><td>Informatika</td><td>230</td><td>Teknologi</td></tr>
              <tr><td>Pemrograman Web</td><td>15-06-2021</td><td>Erlangga</td><td>310</td><td>Teknologi</td></tr>
              <tr><td>Psikologi Remaja</td><td>10-03-2019</td><td>Gramedia</td><td>190</td><td>Psikologi</td></tr>
              <tr><td>Sejarah Dunia</td><td>01-11-2018</td><td>Litera</td><td>450</td><td>Sejarah</td></tr>
              <tr><td>Desain Grafis Modern</td><td>09-02-2022</td><td>Andi Publisher</td><td>280</td><td>Seni</td></tr>
              <tr><td>Dasar Jaringan Komputer</td><td>05-07-2020</td><td>Informatika</td><td>340</td><td>Teknologi</td></tr>
              <tr><td>Matematika Diskrit</td><td>23-08-2019</td><td>Erlangga</td><td>220</td><td>Pendidikan</td></tr>
              <tr><td>Fisika Dasar</td><td>30-05-2021</td><td>Bumi Aksara</td><td>360</td><td>Sains</td></tr>
              <tr><td>Hukum dan Etika</td><td>14-09-2020</td><td>Cahaya Ilmu</td><td>250</td><td>Hukum</td></tr>
              <tr><td>Novel Bumi Manusia</td><td>17-01-2017</td><td>Lentera</td><td>480</td><td>Fiksi</td></tr>
            </tbody>
          </table>
        </section>

        <!-- Riwayat Peminjaman -->
        <section id="riwayat" class="mb-5">
          <h4>📜 Riwayat Peminjaman Buku</h4>
          <table class="table table-bordered table-striped">
            <thead class="table-warning">
              <tr><th>Tanggal</th><th>Bulan</th><th>Tahun</th><th>Tanda Tangan Peminjam</th></tr>
            </thead>
            <tbody>
              <tr><td>12</td><td>Oktober</td><td>2025</td><td>✍️ Ryan Kai</td></tr>
              <tr><td>14</td><td>Oktober</td><td>2025</td><td>✍️ Sinta Ayu</td></tr>
            </tbody>
          </table>
        </section>

        <!-- Scan Buku -->
        <section id="scan" class="mb-5 text-center">
          <h4>🔍 Scan Buku</h4>
          <p>Gunakan kamera atau alat scanner untuk meminjam buku.</p>
          <button class="btn btn-primary">Mulai Scan</button>
        </section>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
