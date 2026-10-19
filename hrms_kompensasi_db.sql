-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Okt 2026 pada 17.27
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrms_kompensasi_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan`
--

CREATE TABLE `jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `id_grade` int(11) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL,
  `kategori_jabatan` enum('Eksekutif','Profesional','Staf') NOT NULL,
  `level_penjenjangan` enum('Junior','Middle','Senior','Lead','Expert','Top Management') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `id_grade`, `nama_jabatan`, `kategori_jabatan`, `level_penjenjangan`) VALUES
(1, 2, 'Staff Administrasi Keuangan', 'Staf', 'Junior'),
(2, 5, 'Senior Software Engineer', 'Profesional', 'Senior'),
(3, 8, 'Financial Controller', 'Eksekutif', 'Expert');

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `nik` varchar(30) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `alamat` text NOT NULL,
  `tax_id` varchar(30) DEFAULT NULL,
  `sertifikasi` text DEFAULT NULL,
  `masa_kerja` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `id_jabatan`, `nik`, `nama_lengkap`, `alamat`, `tax_id`, `sertifikasi`, `masa_kerja`) VALUES
(1, 1, 'EMP-2026-001', 'Budi Santoso', 'Jl. Sudirman No. 45, Jakarta Selatan', '74.123.456.7-021.000', 'Certified Financial Administrator', 24),
(2, 2, 'EMP-2026-002', 'Siti Rahmawati', 'Jl. HR Rasuna Said Blok C, Jakarta Selatan', '82.987.654.3-042.000', 'AWS Certified Developer, Professional Scrum Master', 36),
(3, 3, 'EMP-2026-003', 'Ahmad Fauzi Pratama', 'Jl. Gatot Subroto Kav. 12, Jakarta Pusat', '91.456.789.2-011.000', 'Chartered Accountant (CA), CPA', 60),
(4, 3, 'EMP-2026-004', 'Ab', 'Pulomas', '123456', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `payroll_sheet`
--

CREATE TABLE `payroll_sheet` (
  `id_payroll` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `periode_payroll` varchar(7) NOT NULL,
  `gaji_pokok` decimal(15,2) NOT NULL,
  `take_home_pay` decimal(15,2) NOT NULL,
  `status_approval` enum('Draft','Audited','Approved','Rejected') DEFAULT 'Draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `payroll_sheet`
--

INSERT INTO `payroll_sheet` (`id_payroll`, `id_karyawan`, `periode_payroll`, `gaji_pokok`, `take_home_pay`, `status_approval`) VALUES
(4, 4, '2026-10', 100000000.00, 101350000.00, 'Draft');

-- --------------------------------------------------------

--
-- Struktur dari tabel `struktur_gaji`
--

CREATE TABLE `struktur_gaji` (
  `id_grade` int(11) NOT NULL,
  `pay_grade_code` varchar(20) NOT NULL,
  `min_salary` decimal(15,2) NOT NULL,
  `midpoint_salary` decimal(15,2) NOT NULL,
  `max_salary` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `struktur_gaji`
--

INSERT INTO `struktur_gaji` (`id_grade`, `pay_grade_code`, `min_salary`, `midpoint_salary`, `max_salary`) VALUES
(1, 'G-01', 4000000.00, 5000000.00, 6000000.00),
(2, 'G-02', 5500000.00, 7000000.00, 8500000.00),
(3, 'G-03', 7500000.00, 9500000.00, 11500000.00),
(4, 'G-04', 10000000.00, 12500000.00, 15000000.00),
(5, 'G-05', 13500000.00, 16500000.00, 19500000.00),
(6, 'G-06', 18000000.00, 22000000.00, 26000000.00),
(7, 'G-07', 24000000.00, 29000000.00, 34000000.00),
(8, 'G-08', 31000000.00, 37500000.00, 44000000.00),
(9, 'G-09', 40000000.00, 48000000.00, 56000000.00),
(10, 'G-10', 52000000.00, 62500000.00, 73000000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_pembayaran`
--

CREATE TABLE `transaksi_pembayaran` (
  `id_transaksi` int(11) NOT NULL,
  `id_payroll` int(11) NOT NULL,
  `tanggal_transfer` datetime DEFAULT current_timestamp(),
  `nomor_referensi` varchar(100) NOT NULL,
  `status_transfer` enum('Success','Failed','Pending') DEFAULT 'Pending',
  `bukti_transfer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi_pembayaran`
--

INSERT INTO `transaksi_pembayaran` (`id_transaksi`, `id_payroll`, `tanggal_transfer`, `nomor_referensi`, `status_transfer`, `bukti_transfer`) VALUES
(3, 4, '2026-10-19 20:52:59', '20261020', 'Success', 'uploads/bukti_1792417979_6ad620bbd85be.png');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`),
  ADD KEY `fk_jabatan_grade` (`id_grade`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD UNIQUE KEY `tax_id` (`tax_id`),
  ADD KEY `fk_karyawan_jabatan` (`id_jabatan`);

--
-- Indeks untuk tabel `payroll_sheet`
--
ALTER TABLE `payroll_sheet`
  ADD PRIMARY KEY (`id_payroll`),
  ADD KEY `fk_payroll_karyawan` (`id_karyawan`);

--
-- Indeks untuk tabel `struktur_gaji`
--
ALTER TABLE `struktur_gaji`
  ADD PRIMARY KEY (`id_grade`),
  ADD UNIQUE KEY `pay_grade_code` (`pay_grade_code`);

--
-- Indeks untuk tabel `transaksi_pembayaran`
--
ALTER TABLE `transaksi_pembayaran`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `id_payroll` (`id_payroll`),
  ADD UNIQUE KEY `nomor_referensi` (`nomor_referensi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `payroll_sheet`
--
ALTER TABLE `payroll_sheet`
  MODIFY `id_payroll` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `struktur_gaji`
--
ALTER TABLE `struktur_gaji`
  MODIFY `id_grade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `transaksi_pembayaran`
--
ALTER TABLE `transaksi_pembayaran`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jabatan`
--
ALTER TABLE `jabatan`
  ADD CONSTRAINT `fk_jabatan_grade` FOREIGN KEY (`id_grade`) REFERENCES `struktur_gaji` (`id_grade`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `fk_karyawan_jabatan` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan` (`id_jabatan`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `payroll_sheet`
--
ALTER TABLE `payroll_sheet`
  ADD CONSTRAINT `fk_payroll_karyawan` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi_pembayaran`
--
ALTER TABLE `transaksi_pembayaran`
  ADD CONSTRAINT `fk_transaksi_payroll` FOREIGN KEY (`id_payroll`) REFERENCES `payroll_sheet` (`id_payroll`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
