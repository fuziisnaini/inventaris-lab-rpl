-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 07, 2026 at 03:59 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventaris_lab`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `jumlah` int NOT NULL,
  `kondisi` varchar(50) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `tanggal_input` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `user_id`, `nama_barang`, `kode_barang`, `kategori`, `jumlah`, `kondisi`, `lokasi`, `tanggal_input`, `created_at`, `updated_at`) VALUES
(1, 1, 'PC', '2333', 'Komputer', 20, 'Baik', 'mr', '2026-06-06', NULL, NULL),
(2, 1, 'Laptop ASUS ROG', 'LAB-RPL-001', 'Komputer', 5, 'Baik', 'Lemari A1', '2026-06-01', NULL, NULL),
(3, 1, 'Router Mikrotik RB951', 'LAB-RPL-002', 'Jaringan', 3, 'Baik', 'Rak Server', '2026-06-02', NULL, NULL),
(4, 1, 'Switch Cisco 24 Port', 'LAB-RPL-003', 'Jaringan', 2, 'Rusak', 'Meja Praktik 1', '2026-06-02', NULL, NULL),
(5, 1, 'Kabel LAN Belden Cat6', 'LAB-RPL-004', 'Jaringan', 1, 'Baik', 'Gudang Lab', '2026-06-03', NULL, NULL),
(6, 1, 'Proyektor Epson X41', 'LAB-RPL-005', 'Multimedia', 2, 'Perlu Perbaikan', 'Langit-langit Lab', '2026-06-04', NULL, NULL),
(7, 1, 'PC Rakitan i5 vga GTX', 'LAB-RPL-006', 'Komputer', 10, 'Baik', 'Meja Komputer Deret A', '2026-06-05', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'fuzi isnaini', 'ap@mail.com', '$2y$10$bAUY8A1vhVh8xp54LLj.HO4MPj/b3Wxfbt6vbWh4GYbcRnxSzT9Tm', NULL, NULL),
(2, 'fuza isnaina', 'ip@mail.com', '$2y$10$M6tKolnJMY78RA5QnVs7NOPDinHrIsiwhyHHBsFbrddj.5.nGXwZi', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
