-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2025 at 03:01 PM
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
-- Database: `db_service_gadget_pwl`
--

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `posisi` enum('admin','teknisi') NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `username`, `password`, `posisi`, `email`) VALUES
('ID001', 'Martin Aron', '$2y$10$XZ4eoFKBVJFc1BLkGKk3geHlz5hLuyuagZg4cvZ8zetkO2wMI0NxC', 'admin', 'example@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` varchar(10) NOT NULL,
  `nama_pelanggan` text NOT NULL,
  `jenis_kelamin` text NOT NULL,
  `nomor_telepon` char(20) NOT NULL,
  `alamat` text NOT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `jenis_kelamin`, `nomor_telepon`, `alamat`, `tanggal`) VALUES
('PLG001', 'Martin Aaron', 'Pria', '1234567890', 'Cakung', '2025-06-20 21:21:00'),
('PLG002', 'Ahmad Nur', 'Pria', '45454545454', 'Pasar Minggu', '2025-06-30 21:21:00'),
('PLG003', 'Amelia P', 'Wanita', '1010101010', 'Condet', '2025-06-01 21:22:00'),
('PLG004', 'Riris Sintia', 'Wanita', '081234567843', 'Kali Sari, Jakarta Barat', '2025-06-23 09:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

CREATE TABLE `service` (
  `id_service` char(10) NOT NULL,
  `jenis_service` varchar(255) NOT NULL,
  `biaya_service` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id_service`, `jenis_service`, `biaya_service`) VALUES
('SRV001', 'Servis Layar Laptop Macbook', 100001),
('SRV002', 'Paket Lengkap Pembersihan Laptop', 75001),
('SRV003', 'Pergantian Baterai Laptop', 20000);

-- --------------------------------------------------------

--
-- Table structure for table `sparepart`
--

CREATE TABLE `sparepart` (
  `kd_barang` char(10) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `harga_barang` mediumint(9) NOT NULL,
  `jenis_barang` varchar(255) NOT NULL,
  `merk_barang` varchar(255) NOT NULL,
  `jumlah_barang` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sparepart`
--

INSERT INTO `sparepart` (`kd_barang`, `nama_barang`, `harga_barang`, `jenis_barang`, `merk_barang`, `jumlah_barang`) VALUES
('SP001', 'Layar Macbook', 2300000, 'Layar Laptop', 'Apple', 6),
('SP002', 'Baterai Laptop Asus Zenbook', 1200000, 'Baterai Laptop', 'Asus', 10);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` char(15) NOT NULL,
  `id_pelanggan` varchar(10) NOT NULL,
  `id_service` char(10) NOT NULL,
  `tanggal_masuk` date NOT NULL,
  `kerusakan` text NOT NULL,
  `total_biaya` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pelanggan`, `id_service`, `tanggal_masuk`, `kerusakan`, `total_biaya`) VALUES
('TR2025062313882', 'PLG004', 'SRV001', '2025-06-23', 'Layar laptop bergaris', 100001),
('TR2025062372071', 'PLG004', 'SRV002', '2025-06-23', 'Laptop langsungmati saat baru dinyalakan, kalaupun nyala hanya sebentar saja', 75001),
('TR2025062384555', 'PLG002', 'SRV002', '2025-06-30', 'Hanya mau bersihin laptop', 75001);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_sparepart`
--

CREATE TABLE `transaksi_sparepart` (
  `id_transaksi_sparepart` char(15) NOT NULL,
  `kd_barang` varchar(10) NOT NULL,
  `jumlah` mediumint(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi_sparepart`
--

INSERT INTO `transaksi_sparepart` (`id_transaksi_sparepart`, `kd_barang`, `jumlah`) VALUES
('TR2025062313882', 'SP001', 2),
('TR2025062372071', 'SP002', 1),
('TR2025062384555', 'null', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`id_service`);

--
-- Indexes for table `sparepart`
--
ALTER TABLE `sparepart`
  ADD PRIMARY KEY (`kd_barang`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `transaksi_sparepart`
--
ALTER TABLE `transaksi_sparepart`
  ADD PRIMARY KEY (`id_transaksi_sparepart`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
