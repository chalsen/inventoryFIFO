-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2024 at 06:21 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `retail_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_karyawan`
--

CREATE TABLE `tb_karyawan` (
  `id_karyawan` int(10) NOT NULL,
  `Nama` varchar(35) NOT NULL,
  `alamat` text NOT NULL,
  `np` varchar(11) NOT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `tanggal_lahir` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_karyawan`
--

INSERT INTO `tb_karyawan` (`id_karyawan`, `Nama`, `alamat`, `np`, `jenis_kelamin`, `tanggal_lahir`) VALUES
(4, 'udin', 'iku iku iku', '089876453', 'Laki-Laki', '2003-12-10'),
(6, 'siti', 'alamat alamt', '08965424678', 'Perempuan', '2024-03-08'),
(7, 'ridho ', 'cipete', '0823546798', 'Perempuan', '2002-12-11');

-- --------------------------------------------------------

--
-- Table structure for table `tb_login`
--

CREATE TABLE `tb_login` (
  `id_login` int(10) NOT NULL,
  `id_karyawan` int(10) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `level` enum('karyawan','admin') DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_penjualan_harian`
--

CREATE TABLE `tb_penjualan_harian` (
  `id_penjualan` int(11) NOT NULL,
  `id_produk` int(10) NOT NULL,
  `tanggal` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(40) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_produk`
--

INSERT INTO `tb_produk` (`id_produk`, `nama_produk`, `jumlah`, `harga`) VALUES
(7, 'citato BBQ', 20, 20000),
(12, 'indomie ayam bawang', 13, 4000),
(13, 'indomie rendang', 10, 5000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_rekap_penjualan`
--

CREATE TABLE `tb_rekap_penjualan` (
  `id_rekap` int(10) NOT NULL,
  `id_produk` int(10) NOT NULL,
  `id_karyawan` int(10) NOT NULL,
  `tanggal` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_restok`
--

CREATE TABLE `tb_restok` (
  `id_restok` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `tanggal` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `id_supplier` int(10) NOT NULL,
  `Nama` varchar(35) NOT NULL,
  `alamat` text NOT NULL,
  `np` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_supplier`
--

INSERT INTO `tb_supplier` (`id_supplier`, `Nama`, `alamat`, `np`) VALUES
(3, 'mang jaka', 'kaping kaping', '098764322'),
(4, 'mang udin', 'alamat alamat', '0986123213'),
(5, 'pasar loak', 'jalan kali bata', '08976544121');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_karyawan`
--
ALTER TABLE `tb_karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indexes for table `tb_login`
--
ALTER TABLE `tb_login`
  ADD PRIMARY KEY (`id_login`),
  ADD UNIQUE KEY `karyawan_id` (`id_karyawan`);

--
-- Indexes for table `tb_penjualan_harian`
--
ALTER TABLE `tb_penjualan_harian`
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `tb_rekap_penjualan`
--
ALTER TABLE `tb_rekap_penjualan`
  ADD PRIMARY KEY (`id_rekap`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_karyawan` (`id_karyawan`);

--
-- Indexes for table `tb_restok`
--
ALTER TABLE `tb_restok`
  ADD PRIMARY KEY (`id_restok`),
  ADD KEY `id_barang` (`id_produk`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indexes for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_karyawan`
--
ALTER TABLE `tb_karyawan`
  MODIFY `id_karyawan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_login`
--
ALTER TABLE `tb_login`
  MODIFY `id_login` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_produk`
--
ALTER TABLE `tb_produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_rekap_penjualan`
--
ALTER TABLE `tb_rekap_penjualan`
  MODIFY `id_rekap` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_restok`
--
ALTER TABLE `tb_restok`
  MODIFY `id_restok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `id_supplier` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_login`
--
ALTER TABLE `tb_login`
  ADD CONSTRAINT `tb_login_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `tb_karyawan` (`id_karyawan`);

--
-- Constraints for table `tb_penjualan_harian`
--
ALTER TABLE `tb_penjualan_harian`
  ADD CONSTRAINT `tb_penjualan_harian_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `tb_produk` (`id_produk`);

--
-- Constraints for table `tb_rekap_penjualan`
--
ALTER TABLE `tb_rekap_penjualan`
  ADD CONSTRAINT `tb_rekap_penjualan_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `tb_produk` (`id_produk`),
  ADD CONSTRAINT `tb_rekap_penjualan_ibfk_2` FOREIGN KEY (`id_karyawan`) REFERENCES `tb_karyawan` (`id_karyawan`);

--
-- Constraints for table `tb_restok`
--
ALTER TABLE `tb_restok`
  ADD CONSTRAINT `tb_restok_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `tb_produk` (`id_produk`),
  ADD CONSTRAINT `tb_restok_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `tb_supplier` (`id_supplier`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
