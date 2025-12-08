<?php
session_start();
require_once "koneksi.php";

// Pengamanan: Pastikan user sudah login sebagai 'user'
if (!isset($_SESSION['level']) || $_SESSION['level'] !== "user") {
    header("Location: login.php");
    exit;
}

// Ambil ID anggota dari session (menggunakan id_user yang sudah di set di login.php)
$id_anggota = $_SESSION['id_user'] ?? null;

// ==================== PROSES PEMINJAMAN ====================
$pesan = '';
if (isset($_POST['pinjam'])) {
    $id_buku = $_POST['id_buku'];
    $tanggal_pinjam = date('Y-m-d');
    $tanggal_kembali = date('Y-m-d', strtotime('+7 days'));

    if ($id_anggota) {
        // Cek apakah buku sudah dipinjam dan belum dikembalikan oleh anggota ini
        $cek_pinjam = $koneksi->prepare("
            SELECT COUNT(*) FROM peminjaman 
            WHERE id_anggota = ? AND id_buku = ? AND status_peminjaman = 'Dipinjam'
        ");
        $cek_pinjam->execute([$id_anggota, $id_buku]);
        
        if ($cek_pinjam->fetchColumn() > 0) {
            $pesan = "⚠️ Anda sudah meminjam buku ini dan belum mengembalikannya!";
        } else {
            $stmt = $koneksi->prepare("
                INSERT INTO peminjaman (id_anggota, id_buku, tanggal_pinjam, tanggal_kembali, status_peminjaman)
                VALUES (?, ?, ?, ?, 'Dipinjam')
            ");

            if ($stmt->execute([$id_anggota, $id_buku, $tanggal_pinjam, $tanggal_kembali])) {
                $pesan = "✅ Buku berhasil dipinjam!";
            } else {
                $pesan = "❌ Gagal meminjam buku!";
            }
        }
    } else {
        $pesan = "⚠️ Session ID anggota tidak ditemukan! Harap login ulang.";
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
        .book-card { transition: 0.2s; }
        .book-card:hover { transform: translateY(-6px); box-shadow: 0 6px 18px rgba(0,0,0,0.15); }
        .book-type { font-size: 0.8rem; font-weight: bold; color: #0d6efd; text-transform: uppercase; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php">📚 PerpustakaanKU</a>
        <div class="d-flex">
            <span class="navbar-text me-3 text-white">Halo, <?= htmlspecialchars($_SESSION['nama']) ?>!</span>
            <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <?php if (!empty($pesan)) : ?>
        <div class="alert alert-info text-center"><?= $pesan ?></div>
    <?php endif; ?>

    <h3 class="text-primary mb-4 text-center fw-semibold">📘 Koleksi Buku Perpustakaan</h3>

    <div class="row g-4">

        <?php
        $stmt = $koneksi->query("SELECT * FROM buku ORDER BY id_buku ASC");
        $buku = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($buku):
            foreach ($buku as $item):
        ?>
            <div class="col-md-3">
                <div class="card book-card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($item['judul_buku']); ?></h5>
                        <p><strong>Penulis:</strong> <?= htmlspecialchars($item['penulis']); ?></p>
                        <p><strong>Penerbit:</strong> <?= htmlspecialchars($item['penerbit']); ?></p>
                        <p><strong>Tahun:</strong> <?= htmlspecialchars($item['tahun_terbit']); ?></p>
                        <p class="book-type"><?= htmlspecialchars($item['kategori']); ?></p>
                    </div>
                    <div class="card-footer text-center">
                        <form method="POST">
                            <input type="hidden" name="id_buku" value="<?= $item['id_buku']; ?>">
                            <button type="submit" name="pinjam" class="btn btn-success btn-sm">Pinjam Buku</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach;
        else: ?>
            <p class="text-center text-muted">Tidak ada buku tersedia.</p>
        <?php endif; ?>

    </div>
</div>

<footer class="text-center mt-5 text-secondary small">
    <p>© <?= date("Y") ?> PerpustakaanKU — Sistem Informasi Buku</p>
</footer>

</body>
</html>