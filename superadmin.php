<?php
session_start();
if (!isset($_SESSION['level']) || $_SESSION['level'] != "superadmin") {
    header("Location: login.php");
    exit;
}
require_once 'koneksi.php';

// ========== HANDLE CRUD BUKU ==========
if (isset($_POST['action']) && $_POST['action'] === 'add') {
  $judul = mysqli_real_escape_string($conn, $_POST['judul_buku']);
  $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
  $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
  $tahun = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
  $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
  $jumlah = (int) $_POST['jumlah'];
  $sql = "INSERT INTO buku (judul_buku, penulis, penerbit, tahun_terbit, kategori, jumlah) 
          VALUES ('{$judul}','{$penulis}','{$penerbit}','{$tahun}','{$kategori}',{$jumlah})";
  mysqli_query($conn, $sql);
  header('Location: superadmin.php#buku');
  exit;
}

if (isset($_POST['action']) && $_POST['action'] === 'edit') {
  $id = (int) $_POST['id_buku'];
  $judul = mysqli_real_escape_string($conn, $_POST['judul_buku']);
  $penulis = mysqli_real_escape_string($conn, $_POST['penulis']);
  $penerbit = mysqli_real_escape_string($conn, $_POST['penerbit']);
  $tahun = mysqli_real_escape_string($conn, $_POST['tahun_terbit']);
  $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
  $jumlah = (int) $_POST['jumlah'];
  $sql = "UPDATE buku SET judul_buku='{$judul}', penulis='{$penulis}', penerbit='{$penerbit}', 
          tahun_terbit='{$tahun}', kategori='{$kategori}', jumlah={$jumlah} WHERE id_buku={$id}";
  mysqli_query($conn, $sql);
  header('Location: superadmin.php#buku');
  exit;
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
  $id = (int) $_GET['delete'];
  $sql = "DELETE FROM buku WHERE id_buku={$id}";
  mysqli_query($conn, $sql);
  header('Location: superadmin.php#buku');
  exit;
}

// ========== HANDLE UBAH STATUS PEMINJAMAN ==========
if (isset($_POST['ubah_status'])) {
  $id_peminjaman = $_POST['id_peminjaman'];
  $status = $_POST['status_peminjaman'];
  mysqli_query($conn, "UPDATE peminjaman SET status_peminjaman='$status' WHERE id_peminjaman='$id_peminjaman'");
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
        </ul>
      </div>

      <!-- Main Content -->
      <div class="col-md-10 p-4">
        <h2 class="mb-4 text-primary">Dashboard Superadmin</h2>

        <!-- Data Anggota -->
        <section id="anggota" class="mb-5">
          <h4>👥 Data Anggota</h4>
          <table class="table table-bordered table-striped">
            <thead class="table-primary">
              <tr><th>Nama</th><th>ID Perpustakaan</th><th>Alamat</th></tr>
            </thead>
            <tbody>
              <?php
              $resAng = mysqli_query($conn, "SELECT * FROM anggota ORDER BY id_anggota ASC");
              if ($resAng && mysqli_num_rows($resAng) > 0) {
                while ($angg = mysqli_fetch_assoc($resAng)) {
                  echo '<tr>';
                  echo '<td>' . htmlspecialchars($angg['nama_anggota']) . '</td>';
                  $idPerpustakaan = $angg['id_perpustakaan'] ?? $angg['id_anggota'];
                  echo '<td>' . htmlspecialchars($idPerpustakaan) . '</td>';
                  echo '<td>' . htmlspecialchars($angg['alamat']) . '</td>';
                  echo '</tr>';
                }
              } else {
                echo '<tr><td colspan="3">Tidak ada data anggota</td></tr>';
              }
              ?>
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
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>📘 Data Buku</h4>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Buku</button>
          </div>

          <table class="table table-bordered table-striped">
            <thead class="table-info">
              <tr><th>#</th><th>Judul</th><th>Penulis</th><th>Penerbit</th><th>Tahun</th><th>Kategori</th><th>Jumlah</th><th>Aksi</th></tr>
            </thead>
            <tbody>
              <?php
              $res = mysqli_query($conn, "SELECT * FROM buku ORDER BY id_buku DESC");
              $no = 1;
              while ($row = mysqli_fetch_assoc($res)) {
                  echo '<tr>';
                  echo '<td>' . $no++ . '</td>';
                  echo '<td>' . htmlspecialchars($row['judul_buku']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['penulis']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['penerbit']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['tahun_terbit']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['kategori']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['jumlah']) . '</td>';
                  echo '<td>';
                  echo '<button class="btn btn-sm btn-success me-1" data-bs-toggle="modal" data-bs-target="#editModal' . $row['id_buku'] . '">Edit</button>';
                  echo '<a class="btn btn-sm btn-danger" href="superadmin.php?delete=' . $row['id_buku'] . '" onclick="return confirm(\'Hapus buku ini?\')">Hapus</a>';
                  echo '</td>';
                  echo '</tr>';
              }
              ?>
            </tbody>
          </table>
        </section>

        <!-- Riwayat Peminjaman -->
        <section id="riwayat" class="mb-5">
          <h4>📜 Riwayat Peminjaman Buku</h4>
          <table class="table table-bordered table-striped">
            <thead class="table-warning">
              <tr><th>Nama Anggota</th><th>Judul Buku</th><th>Tanggal Pinjam</th><th>Tanggal Kembali</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
              <?php
              $query = "SELECT p.id_peminjaman, a.nama_anggota, b.judul_buku, p.tanggal_pinjam, p.tanggal_kembali, p.status_peminjaman
                        FROM peminjaman p
                        JOIN anggota a ON p.id_anggota = a.id_anggota
                        JOIN buku b ON p.id_buku = b.id_buku
                        ORDER BY p.tanggal_pinjam DESC";
              $result = mysqli_query($conn, $query);
              if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  echo '<tr>';
                  echo '<td>' . htmlspecialchars($row['nama_anggota']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['judul_buku']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['tanggal_pinjam']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['tanggal_kembali']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['status_peminjaman']) . '</td>';
                  echo '<td>
                        <form method="post" class="d-inline">
                          <input type="hidden" name="id_peminjaman" value="'.$row['id_peminjaman'].'">
                          <select name="status_peminjaman" class="form-select form-select-sm d-inline w-auto">
                            <option '.($row['status_peminjaman']=='Dipinjam'?'selected':'').'>Dipinjam</option>
                            <option '.($row['status_peminjaman']=='Dikembalikan'?'selected':'').'>Dikembalikan</option>
                          </select>
                          <button type="submit" name="ubah_status" class="btn btn-sm btn-primary">Simpan</button>
                        </form>
                      </td>';
                  echo '</tr>';
                }
              } else {
                echo '<tr><td colspan="6">Belum ada data peminjaman</td></tr>';
              }
              ?>
            </tbody>
          </table>
        </section>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
