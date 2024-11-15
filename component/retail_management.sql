-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Okt 2024 pada 03.10
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.2.0

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
-- Struktur dari tabel `tb_karyawan`
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
-- Dumping data untuk tabel `tb_karyawan`
--

INSERT INTO `tb_karyawan` (`id_karyawan`, `Nama`, `alamat`, `np`, `jenis_kelamin`, `tanggal_lahir`) VALUES
(7, 'admin', 'cipete', '0823546798', 'Perempuan', '2002-12-11'),
(8, 'udin', 'rawabebek', '08909612323', 'Laki-Laki', '2002-02-12'),
(9, 'siti', 'pasar baru', '09087234', 'Perempuan', '2000-02-22'),
(10, 'juned', 'jln rambutan', '09127361213', 'Laki-Laki', '2003-05-26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `id_kategori` int(11) NOT NULL,
  `kategori` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kategori`
--

INSERT INTO `tb_kategori` (`id_kategori`, `kategori`) VALUES
(1, 'ATK'),
(2, 'Makanan'),
(6, 'Alat Sholat'),
(13, 'alat mandi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_login`
--

CREATE TABLE `tb_login` (
  `id_login` int(10) NOT NULL,
  `id_karyawan` int(10) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `level` enum('karyawan','admin') DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_login`
--

INSERT INTO `tb_login` (`id_login`, `id_karyawan`, `username`, `password`, `level`, `waktu`) VALUES
(3, 7, 'admin123', 'admin123', 'admin', '2024-10-23 01:05:44'),
(5, 8, 'udingans01', 'udingans01', 'karyawan', '2024-10-24 03:28:37'),
(12, 10, 'junedgans', 'junedgans', 'karyawan', '2024-05-18 14:40:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_penjualan_harian`
--

CREATE TABLE `tb_penjualan_harian` (
  `id_penjualan` int(11) NOT NULL,
  `id_produk` int(10) NOT NULL,
  `penjualan` int(11) NOT NULL,
  `toko` varchar(120) NOT NULL,
  `alamat` text NOT NULL,
  `tanggal` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(40) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 0,
  `id_kategori` int(11) DEFAULT NULL,
  `harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_produk`
--

INSERT INTO `tb_produk` (`id_produk`, `nama_produk`, `jumlah`, `id_kategori`, `harga`) VALUES
(7, 'citato BBQ', 109, 2, 2000),
(12, 'indomie ayam bawang', 57, 2, 4000),
(13, 'indomie rendang', 44, 2, 5000),
(15, 'sikat gigi', 38, 13, 2000),
(18, 'Pulpen standart', 0, 1, 3000),
(19, 'kapur', 4, 1, 2000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rekap_penjualan`
--

CREATE TABLE `tb_rekap_penjualan` (
  `id_rekap` int(10) NOT NULL,
  `produk` varchar(45) NOT NULL,
  `harga` int(11) NOT NULL,
  `toko` varchar(120) NOT NULL,
  `alamat` text NOT NULL,
  `nama_perekap` varchar(40) NOT NULL,
  `terjual` int(11) NOT NULL,
  `tanggal` date NOT NULL DEFAULT curdate(),
  `tanggal_rekap` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_rekap_penjualan`
--

INSERT INTO `tb_rekap_penjualan` (`id_rekap`, `produk`, `harga`, `toko`, `alamat`, `nama_perekap`, `terjual`, `tanggal`, `tanggal_rekap`) VALUES
(22, 'indomie ayam bawang', 4000, '', '', 'udin', 11, '2024-02-13', '2024-04-01'),
(24, 'Pulpen standart', 3000, '', '', 'udin', 10, '2024-03-12', '2024-04-01'),
(25, 'citato BBQ', 2000, '', '', 'udin', 6, '2024-04-11', '2024-04-01'),
(30, 'citato BBQ', 2000, '', '', 'udin', 7, '2024-04-08', '2024-04-07'),
(31, 'indomie ayam bawang', 4000, '', '', 'udin', 20, '2024-04-07', '2024-04-07'),
(32, 'indomie rendang', 5000, '', '', 'udin', 10, '2024-04-01', '2024-04-07'),
(33, 'Pulpen standart', 3000, '', '', 'udin', 4, '2024-04-09', '2024-04-07'),
(39, 'citato BBQ', 2000, '', '', 'udin', 10, '2024-04-19', '2024-04-19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_restok`
--

CREATE TABLE `tb_restok` (
  `id_restok` int(11) NOT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `id_supplier` int(11) DEFAULT NULL,
  `jumlah_restok` int(11) NOT NULL,
  `tanggal` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_restok`
--

INSERT INTO `tb_restok` (`id_restok`, `id_produk`, `id_supplier`, `jumlah_restok`, `tanggal`) VALUES
(39, 7, 3, 100, '2024-04-15'),
(40, 12, 5, 58, '2024-04-15'),
(41, 13, 5, 48, '2024-04-15'),
(42, 15, 3, 30, '2024-04-15'),
(43, 18, 3, 20, '2024-04-15'),
(47, 7, 3, 20, '2024-04-19'),
(49, 12, 3, 10, '2024-04-19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `id_supplier` int(10) NOT NULL,
  `Nama` varchar(35) NOT NULL,
  `alamat` text NOT NULL,
  `np` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_supplier`
--

INSERT INTO `tb_supplier` (`id_supplier`, `Nama`, `alamat`, `np`) VALUES
(3, 'mang jaka', 'kaping kaping', '098764322'),
(5, 'pasar loak', 'jalan kali bata', '08976544121'),
(9, 'mang udin', 'tangerang', '081931243');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_karyawan`
--
ALTER TABLE `tb_karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indeks untuk tabel `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `tb_login`
--
ALTER TABLE `tb_login`
  ADD PRIMARY KEY (`id_login`),
  ADD UNIQUE KEY `karyawan_id` (`id_karyawan`);

--
-- Indeks untuk tabel `tb_penjualan_harian`
--
ALTER TABLE `tb_penjualan_harian`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `tb_produk_ibfk_1` (`id_kategori`);

--
-- Indeks untuk tabel `tb_rekap_penjualan`
--
ALTER TABLE `tb_rekap_penjualan`
  ADD PRIMARY KEY (`id_rekap`);

--
-- Indeks untuk tabel `tb_restok`
--
ALTER TABLE `tb_restok`
  ADD PRIMARY KEY (`id_restok`),
  ADD KEY `id_barang` (`id_produk`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indeks untuk tabel `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_karyawan`
--
ALTER TABLE `tb_karyawan`
  MODIFY `id_karyawan` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tb_kategori`
--
ALTER TABLE `tb_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tb_login`
--
ALTER TABLE `tb_login`
  MODIFY `id_login` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tb_penjualan_harian`
--
ALTER TABLE `tb_penjualan_harian`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `tb_produk`
--
ALTER TABLE `tb_produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tb_rekap_penjualan`
--
ALTER TABLE `tb_rekap_penjualan`
  MODIFY `id_rekap` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `tb_restok`
--
ALTER TABLE `tb_restok`
  MODIFY `id_restok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT untuk tabel `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `id_supplier` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_login`
--
ALTER TABLE `tb_login`
  ADD CONSTRAINT `tb_login_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `tb_karyawan` (`id_karyawan`);

--
-- Ketidakleluasaan untuk tabel `tb_penjualan_harian`
--
ALTER TABLE `tb_penjualan_harian`
  ADD CONSTRAINT `tb_penjualan_harian_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `tb_produk` (`id_produk`);

--
-- Ketidakleluasaan untuk tabel `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD CONSTRAINT `tb_produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `tb_kategori` (`id_kategori`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ketidakleluasaan untuk tabel `tb_restok`
--
ALTER TABLE `tb_restok`
  ADD CONSTRAINT `tb_restok_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `tb_produk` (`id_produk`),
  ADD CONSTRAINT `tb_restok_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `tb_supplier` (`id_supplier`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
