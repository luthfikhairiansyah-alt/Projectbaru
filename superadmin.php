<?php
session_start();
require_once "koneksi.php";

// Pengamanan: Hanya untuk superadmin
if (!isset($_SESSION['level']) || $_SESSION['level'] !== "superadmin") {
    header("Location: login.php");
    exit;
}

// ================== HANDLE CRUD BUKU ==================

if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $stmt = $koneksi->prepare("INSERT INTO buku (judul_buku, penulis, penerbit, tahun_terbit, kategori, jumlah) 
                                 VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $_POST['judul_buku'],
        $_POST['penulis'],
        $_POST['penerbit'],
        $_POST['tahun_terbit'],
        $_POST['kategori'],
        $_POST['jumlah']
    ]);

    header("Location: superadmin.php#buku");
    exit;
}

if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $stmt = $koneksi->prepare("UPDATE buku SET judul_buku=?, penulis=?, penerbit=?, tahun_terbit=?, kategori=?, jumlah=? 
                                 WHERE id_buku=?");

    $stmt->execute([
        $_POST['judul_buku'],
        $_POST['penulis'],
        $_POST['penerbit'],
        $_POST['tahun_terbit'],
        $_POST['kategori'],
        $_POST['jumlah'],
        $_POST['id_buku']
    ]);

    header("Location: superadmin.php#buku");
    exit;
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $stmt = $koneksi->prepare("DELETE FROM buku WHERE id_buku=?");
    $stmt->execute([$_GET['delete']]);

    header("Location: superadmin.php#buku");
    exit;
}

// ================== UPDATE STATUS PEMINJAMAN ==================

if (isset($_POST['ubah_status'])) {
    $stmt = $koneksi->prepare("UPDATE peminjaman SET status_peminjaman=? WHERE id_peminjaman=?");
    $stmt->execute([$_POST['status_peminjaman'], $_POST['id_peminjaman']]);

    header("Location: superadmin.php#riwayat");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Superadmin - PerpustakaanKU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php">📚 PerpustakaanKU</a>
      <div class="d-flex">
        <span class="navbar-text me-3 text-white">Halo, <?= htmlspecialchars($_SESSION['nama']) ?>!</span>
        <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
      </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 bg-light vh-100 p-3 border-end">
            <h5 class="text-center">Menu</h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="#anggota">👥 Data Anggota</a></li>
                <li class="nav-item"><a class="nav-link" href="#admin">🧑‍💼 Data Admin</a></li>
                <li class="nav-item"><a class="nav-link" href="#buku">📘 Data Buku</a></li>
                <li class="nav-item"><a class="nav-link" href="#riwayat">📜 Riwayat Peminjaman</a></li>
            </ul>
        </div>

        <div class="col-md-10 p-4">
            <h2 class="mb-4 text-primary">Dashboard Superadmin</h2>

            <section id="anggota" class="mb-5">
                <h4>👥 Data Anggota</h4>
                <table class="table table-bordered table-striped">
                    <thead class="table-primary">
                        <tr><th>Nama</th><th>Email</th><th>Alamat</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        // Asumsi kolom anggota: nama_anggota, email, alamat
                        $anggota = $koneksi->query("SELECT * FROM anggota ORDER BY id_anggota ASC")->fetchAll(PDO::FETCH_ASSOC);
                        if ($anggota):
                            foreach ($anggota as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['nama_anggota']) ?></td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td><?= htmlspecialchars($row['alamat']) ?></td>
                                </tr>
                            <?php endforeach;
                        else:
                            echo "<tr><td colspan='3'>Tidak ada data anggota</td></tr>";
                        endif; ?>
                    </tbody>
                </table>
            </section>

            <section id="buku" class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>📘 Data Buku</h4>
                    <a href="tambah_buku.php" class="btn btn-primary btn-sm">Tambah Buku</a>
                </div>

                <table class="table table-bordered table-striped">
                    <thead class="table-info">
                        <tr><th>#</th><th>Judul</th><th>Penulis</th><th>Kategori</th><th>Jumlah</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $buku = $koneksi->query("SELECT * FROM buku ORDER BY id_buku DESC")->fetchAll(PDO::FETCH_ASSOC);
                        $no = 1;
                        foreach ($buku as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['judul_buku']) ?></td>
                                <td><?= htmlspecialchars($row['penulis']) ?></td>
                                <td><?= htmlspecialchars($row['kategori']) ?></td>
                                <td><?= htmlspecialchars($row['jumlah']) ?></td>
                                <td>
                                    <a href="edit_buku.php?id=<?= $row['id_buku'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="superadmin.php?delete=<?= $row['id_buku'] ?>" 
                                        onclick="return confirm('Hapus buku ini?')" 
                                        class="btn btn-danger btn-sm">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>

            <section id="riwayat" class="mb-5">
                <h4>📜 Riwayat Peminjaman</h4>
                <table class="table table-bordered table-striped">
                    <thead class="table-warning">
                        <tr><th>Nama</th><th>Buku</th><th>Pinjam</th><th>Kembali</th><th>Status</th><th>Aksi</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $riwayat = $koneksi->query("
                            SELECT p.*, a.nama_anggota, b.judul_buku 
                            FROM peminjaman p 
                            JOIN anggota a ON p.id_anggota=a.id_anggota 
                            JOIN buku b ON p.id_buku=b.id_buku
                            ORDER BY p.id_peminjaman DESC
                        ")->fetchAll(PDO::FETCH_ASSOC);

                        if ($riwayat):
                            foreach ($riwayat as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nama_anggota']) ?></td>
                                <td><?= htmlspecialchars($row['judul_buku']) ?></td>
                                <td><?= htmlspecialchars($row['tanggal_pinjam']) ?></td>
                                <td><?= htmlspecialchars($row['tanggal_kembali']) ?></td>
                                <td><?= htmlspecialchars($row['status_peminjaman']) ?></td>
                                <td>
                                    <form method="post">
                                        <input type="hidden" name="id_peminjaman" value="<?= $row['id_peminjaman'] ?>">
                                        <select name="status_peminjaman" class="form-select form-select-sm d-inline w-auto">
                                            <option <?= $row['status_peminjaman']=='Dipinjam'?'selected':'' ?>>Dipinjam</option>
                                            <option <?= $row['status_peminjaman']=='Dikembalikan'?'selected':'' ?>>Dikembalikan</option>
                                        </select>
                                        <button name="ubah_status" class="btn btn-sm btn-primary">Simpan</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach;
                        else:
                            echo "<tr><td colspan='6'>Belum ada data</td></tr>";
                        endif; ?>
                    </tbody>
                </table>
            </section>
             <section id="admin" class="mb-5">
                <h4>🧑‍💼 Data Admin</h4>
                <p>Konten data admin (pengguna admin lain) Anda akan ditempatkan di sini.</p>
            </section>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>