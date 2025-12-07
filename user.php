<?php 
session_start();
include 'koneksi.php';

// pastikan user sudah login
if (!isset($_SESSION['level']) || $_SESSION['level'] != "user") {
    header("Location: login.php");
    exit;
}

// Ambil id_anggota dari session login
// Saat login, pastikan kamu menyimpan $_SESSION['id_anggota'] di file login.php
$id_anggota = $_SESSION['id_anggota'] ?? null;

// proses peminjaman
if (isset($_POST['pinjam'])) {
    $id_buku = $_POST['id_buku'];
    $tanggal_pinjam = date('Y-m-d');
    $tanggal_kembali = date('Y-m-d', strtotime('+7 days')); // contoh: otomatis 7 hari ke depan

    if ($id_anggota) {
        // simpan ke tabel peminjaman
        $query = "INSERT INTO peminjaman (id_anggota, id_buku, tanggal_pinjam, tanggal_kembali, status_peminjaman) 
                  VALUES ('$id_anggota', '$id_buku', '$tanggal_pinjam', '$tanggal_kembali', 'Dipinjam')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $pesan = "✅ Buku berhasil dipinjam!";
        } else {
            $pesan = "❌ Gagal meminjam buku: " . mysqli_error($conn);
        }
    } else {
        $pesan = "⚠️ Data anggota tidak ditemukan dalam session.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Buku - PerpustakaanKU</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .book-card { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .book-card:hover { transform: translateY(-6px); box-shadow: 0 6px 14px rgba(0,0,0,0.15); }
    .book-type { font-size: 0.9rem; font-weight: bold; color: #0d6efd; text-transform: uppercase; }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">📚 PerpustakaanKU</a>
    <div class="d-flex">
      <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <?php if (isset($pesan)) : ?>
    <div class="alert alert-info text-center"><?= $pesan; ?></div>
  <?php endif; ?>

  <h3 class="text-primary mb-4 text-center fw-semibold">📘 Koleksi Buku Perpustakaan</h3>

  <div class="row g-4 justify-content-center">

    <?php
    // ambil data buku dari database
    $res = mysqli_query($conn, "SELECT * FROM buku ORDER BY id_buku ASC LIMIT 5");
    while ($item = mysqli_fetch_assoc($res)): ?>
      <div class="col-md-3">
        <div class="card book-card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($item['judul_buku']); ?></h5>
            <p class="mb-1"><strong>Penulis:</strong> <?= htmlspecialchars($item['penulis']); ?></p>
            <p class="mb-1"><strong>Penerbit:</strong> <?= htmlspecialchars($item['penerbit']); ?></p>
            <p class="mb-1"><strong>Tahun:</strong> <?= htmlspecialchars($item['tahun_terbit']); ?></p>
            <p class="book-type mt-2"><?= htmlspecialchars($item['kategori']); ?></p>
          </div>
          <div class="card-footer text-center">
            <form method="POST">
              <input type="hidden" name="id_buku" value="<?= $item['id_buku']; ?>">
              <button type="submit" name="pinjam" class="btn btn-success btn-sm">Pinjam Buku</button>
            </form>
          </div>
        </div>
      </div>
    <?php endwhile; ?>

  </div>
</div>

<footer class="text-center mt-5 text-secondary small">
  <p>© <?= date("Y") ?> PerpustakaanKU — Sistem Informasi Buku</p>
</footer>

</body>
</html>
