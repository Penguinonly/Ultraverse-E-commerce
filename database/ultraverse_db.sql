-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 13, 2025 at 05:10 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ultraverse_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `dokumen`
--

CREATE TABLE `dokumen` (
  `dokumen_id` int NOT NULL,
  `properti_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `nama_dokumen` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_path` text COLLATE utf8mb4_general_ci,
  `status` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_upload` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorit`
--

CREATE TABLE `favorit` (
  `user_id` int NOT NULL,
  `properti_id` int NOT NULL,
  `tanggal_disimpan` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gambar_properti`
--

CREATE TABLE `gambar_properti` (
  `gambar_id` int NOT NULL,
  `properti_id` int DEFAULT NULL,
  `url_gambar` text COLLATE utf8mb4_general_ci,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `urutan` int DEFAULT NULL,
  `tanggal_upload` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laporan_inspeksi`
--

CREATE TABLE `laporan_inspeksi` (
  `laporan_id` int NOT NULL,
  `inspektor_id` int DEFAULT NULL,
  `properti_id` int DEFAULT NULL,
  `isi_laporan` text COLLATE utf8mb4_general_ci,
  `tanggal_inspeksi` datetime DEFAULT NULL,
  `status_laporan` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `log_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `aktivitas` text COLLATE utf8mb4_general_ci,
  `waktu` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `notifikasi_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `isi_pesan` text COLLATE utf8mb4_general_ci,
  `tanggal` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `pembayaran_id` int NOT NULL,
  `transaksi_id` int DEFAULT NULL,
  `metode_pembayaran` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jumlah` decimal(15,2) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `status_pembayaran` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bukti_pembayaran` text COLLATE utf8mb4_general_ci,
  `tanggal_pembayaran` datetime DEFAULT NULL,
  `konfirmasi_pembayaran` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peran`
--

CREATE TABLE `peran` (
  `id_peran` int NOT NULL,
  `Peran` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `percakapan`
--

CREATE TABLE `percakapan` (
  `percakapan_id` int NOT NULL,
  `tipe_percakapan` enum('pelanggan-admin','penjual-admin') NOT NULL,
  `dibuat_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `terakhir_pesan` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesan`
--

CREATE TABLE `pesan` (
  `pesan_id` int NOT NULL,
  `percakapan_id` int NOT NULL,
  `pengirim_id` int NOT NULL,
  `isi_pesan` text NOT NULL,
  `dikirim_pada` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('sent','delivered','read') NOT NULL DEFAULT 'sent'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peserta_percakapan`
--

CREATE TABLE `peserta_percakapan` (
  `percakapan_id` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properti`
--

CREATE TABLE `properti` (
  `properti_id` int NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `harga` decimal(15,2) DEFAULT NULL,
  `lokasi` text COLLATE utf8mb4_general_ci,
  `status` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rating_ulasan`
--

CREATE TABLE `rating_ulasan` (
  `ulasan_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `properti_id` int DEFAULT NULL,
  `nilai_rating` int DEFAULT NULL,
  `komentar` text COLLATE utf8mb4_general_ci,
  `tanggal` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_properti`
--

CREATE TABLE `riwayat_properti` (
  `riwayat_id` int NOT NULL,
  `properti_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `perubahan` text COLLATE utf8mb4_general_ci,
  `waktu` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `session_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `transaksi_id` int NOT NULL,
  `pembeli_id` int DEFAULT NULL,
  `properti_id` int DEFAULT NULL,
  `tanggal_transaksi` datetime DEFAULT NULL,
  `status_transaksi` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_transaksi` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `transaksi_admin` text COLLATE utf8mb4_general_ci,
  `total_harga` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `Password` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `No KTP` int NOT NULL,
  `Nama Lengkap` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `Email` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `No Telepon` int NOT NULL,
  `Alamat` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `Foto KTP` longblob NOT NULL,
  `Verivikasi Wajah` longblob NOT NULL,
  `Pendapatan Perbulan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_peran`
--

CREATE TABLE `user_peran` (
  `user_id` int NOT NULL,
  `id_peran` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dokumen`
--
ALTER TABLE `dokumen`
  ADD PRIMARY KEY (`dokumen_id`),
  ADD KEY `properti_id` (`properti_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `favorit`
--
ALTER TABLE `favorit`
  ADD PRIMARY KEY (`user_id`,`properti_id`),
  ADD KEY `properti_id` (`properti_id`);

--
-- Indexes for table `gambar_properti`
--
ALTER TABLE `gambar_properti`
  ADD PRIMARY KEY (`gambar_id`),
  ADD KEY `properti_id` (`properti_id`);

--
-- Indexes for table `laporan_inspeksi`
--
ALTER TABLE `laporan_inspeksi`
  ADD PRIMARY KEY (`laporan_id`),
  ADD KEY `inspektor_id` (`inspektor_id`),
  ADD KEY `properti_id` (`properti_id`);

--
-- Indexes for table `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`notifikasi_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`pembayaran_id`),
  ADD KEY `transaksi_id` (`transaksi_id`);

--
-- Indexes for table `peran`
--
ALTER TABLE `peran`
  ADD PRIMARY KEY (`id_peran`);

--
-- Indexes for table `percakapan`
--
ALTER TABLE `percakapan`
  ADD PRIMARY KEY (`percakapan_id`);

--
-- Indexes for table `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`pesan_id`),
  ADD KEY `pengirim_id` (`pengirim_id`),
  ADD KEY `idx_percakkan_pesan` (`percakapan_id`,`dikirim_pada`);

--
-- Indexes for table `peserta_percakapan`
--
ALTER TABLE `peserta_percakapan`
  ADD PRIMARY KEY (`percakapan_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `properti`
--
ALTER TABLE `properti`
  ADD PRIMARY KEY (`properti_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rating_ulasan`
--
ALTER TABLE `rating_ulasan`
  ADD PRIMARY KEY (`ulasan_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `properti_id` (`properti_id`);

--
-- Indexes for table `riwayat_properti`
--
ALTER TABLE `riwayat_properti`
  ADD PRIMARY KEY (`riwayat_id`),
  ADD KEY `properti_id` (`properti_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`transaksi_id`),
  ADD KEY `pembeli_id` (`pembeli_id`),
  ADD KEY `properti_id` (`properti_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_peran`
--
ALTER TABLE `user_peran`
  ADD PRIMARY KEY (`user_id`,`id_peran`),
  ADD KEY `id_peran` (`id_peran`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `percakapan`
--
ALTER TABLE `percakapan`
  MODIFY `percakapan_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesan`
--
ALTER TABLE `pesan`
  MODIFY `pesan_id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gambar_properti`
--
ALTER TABLE `gambar_properti`
  ADD CONSTRAINT `gambar_properti_ibfk_1` FOREIGN KEY (`properti_id`) REFERENCES `properti` (`properti_id`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`transaksi_id`);

--
-- Constraints for table `pesan`
--
ALTER TABLE `pesan`
  ADD CONSTRAINT `pesan_ibfk_1` FOREIGN KEY (`percakapan_id`) REFERENCES `percakapan` (`percakapan_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pesan_ibfk_2` FOREIGN KEY (`pengirim_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `peserta_percakapan`
--
ALTER TABLE `peserta_percakapan`
  ADD CONSTRAINT `peserta_percakapan_ibfk_1` FOREIGN KEY (`percakapan_id`) REFERENCES `percakapan` (`percakapan_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peserta_percakapan_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
