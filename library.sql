CREATE DATABASE IF NOT EXISTS db_library
USE db_library

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2025 at 07:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `username`, `password`, `email`, `no_telp`, `tanggal_dibuat`) VALUES
(1, 'Muhammad Aufa', 'admin1', 'admin123', 'admin@library.com', NULL, '2025-10-15 01:16:52'),
(2, 'Budi Santoso', 'admin2', 'admin456', 'budi@library.com', NULL, '2025-10-15 01:16:52'),
(3, 'Siti Aminah', 'admin3', 'admin789', 'siti@library.com', NULL, '2025-10-15 01:16:52'),
(4, 'Rina Kurnia', 'admin4', 'admin321', 'rina@library.com', NULL, '2025-10-15 01:16:52');

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `nama_anggota` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `tanggal_daftar` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `nama_anggota`, `alamat`, `no_telp`, `email`, `password`, `tanggal_daftar`) VALUES
(1, 'Budi Santoso', 'Jl. Mawar No.1', '081234567890', 'budi@gmail.com', 'budi123', '2025-10-15'),
(2, 'Siti Aminah', 'Jl. Melati No.2', '082233445566', 'siti@gmail.com', 'siti234', '2025-10-15'),
(3, 'Ahmad Fauzi', 'Jl. Kenanga No.3', '083344556677', 'ahmad@gmail.com', 'ahmad345', '2025-10-15'),
(4, 'Dina Larasati', 'Jl. Dahlia No.4', '084455667788', 'dina@gmail.com', 'dina456', '2025-10-15'),
(5, 'Andi Prasetyo', 'Jl. Anggrek No.5', '085566778899', 'andi@gmail.com', '7890', '2025-10-15');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul_buku` varchar(150) NOT NULL,
  `penulis` varchar(100) DEFAULT NULL,
  `penerbit` varchar(100) DEFAULT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT 0,
  `tanggal_input` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `judul_buku`, `penulis`, `penerbit`, `tahun_terbit`, `kategori`, `jumlah`, `tanggal_input`) VALUES
(1, 'Belajar PHP Dasar', 'Andi Setiawan', 'Informatika', '2022', 'Pemrograman', 5, '2025-10-15 01:17:09'),
(2, 'MongoDB Fundamentals', 'Shreyas Karekar', 'Packt', '2020', 'Database', 3, '2025-10-15 01:17:09'),
(3, 'HTML & CSS untuk Pemula', 'Dewi Lestari', 'Elex Media', '2021', 'Web Design', 7, '2025-10-15 01:17:09'),
(4, 'Python untuk Semua', 'Bambang Hartono', 'Gramedia', '2023', 'Pemrograman', 4, '2025-10-15 01:17:09'),
(5, 'Manajemen Basis Data', 'Ridwan Saputra', 'Informatika', '2019', 'Database', 6, '2025-10-15 01:17:09');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_buku`
--

CREATE TABLE `transaksi_buku` (
  `id_transaksi` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('Dipinjam','Dikembalikan') DEFAULT 'Dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_buku`
--

INSERT INTO `transaksi_buku` (`id_transaksi`, `id_anggota`, `id_buku`, `id_admin`, `tanggal_pinjam`, `tanggal_kembali`, `status`) VALUES
(1, 1, 1, 1, '2025-10-10', '2025-10-13', 'Dikembalikan'),
(2, 2, 3, 2, '2025-10-12', NULL, 'Dipinjam'),
(3, 3, 2, 1, '2025-10-14', NULL, 'Dipinjam'),
(4, 4, 5, 3, '2025-10-08', '2025-10-11', 'Dikembalikan'),
(5, 5, 4, 4, '2025-10-15', NULL, 'Dipinjam');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indexes for table `transaksi_buku`
--
ALTER TABLE `transaksi_buku`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_admin` (`id_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaksi_buku`
--
ALTER TABLE `transaksi_buku`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi_buku`
--
ALTER TABLE `transaksi_buku`
  ADD CONSTRAINT `transaksi_buku_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`),
  ADD CONSTRAINT `transaksi_buku_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  ADD CONSTRAINT `transaksi_buku_ibfk_3` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
