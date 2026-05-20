-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Mar 2026 pada 14.24
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
-- Database: `mesinkasir`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `stok_pcs` int(11) NOT NULL,
  `isi_per_dus` int(11) NOT NULL,
  `harga_satuan` int(11) NOT NULL,
  `harga_dus` int(11) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `nama_barang`, `stok_pcs`, `isi_per_dus`, `harga_satuan`, `harga_dus`, `gambar`, `deskripsi`) VALUES
(7, 'Pensil 2b', 29287, 12, 2500, 30000, 'Pencil2B.png\r\n', 'Pensil 2b bermerek Faber Castle yg jelas terjamin kualitasnya.\r\n1 dus berisikan 12 pensil.\r\nbisa dibeli eceran.'),
(17, 'Asus VivoBook A422U', 540, 1, 10000000, 13000000, 'AsusVivoBookA442U.png', 'Laptop enty level yang sangat baik dari segi ram dan cpu generasinya, hanya minus di storage yang masih HDD.\r\n\r\nspesifikasi :\r\nRam 4gb\r\nstorage 256 hdd\r\nIntel core 5 gen 8\r\ngrafis Nvidia Geforce 930MX\r\n'),
(18, 'Redmi 9C', 270, 1, 1400000, 1400000, 'Redmin9C.png', 'Handphone low end yg rekomended karena harga nya yg murah namun memiliki spesifikasi yg oke.\r\nSoC : Helio G35\r\nRam : 3Gb\r\nRom : 32Gb'),
(19, 'Iphone 15 Pro', 235, 1, 17000000, 17000000, 'Iphone 15 Promax.png', 'Iphone seri terbaru dengan fitur yang jauh lebih canggih dari fitur seri sebelumnya.'),
(21, 'Iphone 17 Pro', 216, 1, 20000000, 20000000, 'Iphone17Pro.png', 'Iphone edisi terbaru.\r\n\r\nterdiri 3 Warna ; Hitam, Putih dan orange.'),
(23, 'ROG 9', 121, 1, 10000000, 1000000, 'Rog9.png', 'HP Gaming recomended'),
(24, 'Redmi Note 13 Pro 5G', 52, 1, 5700000, 5700000, 'Redmi Note 13 Pro 5G.png', 'Handphone'),
(26, 'Buku belajar dasar HTML, CSS dan Java Script', 998, 1, 10000, 10000, 'html-css-js.png', 'Buku panduan belajar html,css dan js'),
(27, 'Asus Tuff A15', 273, 1, 15750000, 16000000, '', 'Laptop gaming dengan kualitas terbaik.\r\nCocok untuk harian maupun gaming disertai live streaming.\r\nDibantu dengan cooler yang lebih canggih agar mesin tetap terjaga suhunya.'),
(28, 'Pop Ice Cokelat', 5305, 12, 3000, 12000, '', 'Pop Ice varian rasa cokelat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user',
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telephone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `member`
--

INSERT INTO `member` (`id`, `username`, `role`, `email`, `password`, `telephone`) VALUES
(50, 'Agus Setiawan', 'admin', 'agussetiawan121@gmail.com', 'aguss53t1awan', ''),
(52, 'N0TR34L1TY', 'user', 'n0tr34l1ty@gmail.com', '12111', ''),
(54, 'Rennataa', 'user', 'rennataro26@gmail.com', 'renna5541', ''),
(55, 'Justice', 'user', 'justiceforfreedom55@gmail.com', 'justice45', ''),
(61, 'Bima', 'admin', 'bimagang26@gmal.com', 'bima123', ''),
(62, 'Fatih', 'admin', 'Fatihrpl2@gmail.com', 'fatih', ''),
(63, 'Nabila', 'admin', 'nabilaerpl2@gmail.com', 'bilaa343', ''),
(66, 'Radit', 'admin', 'radityaaputraa55@gmail.com', 'aditt', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_transaksi`
--

CREATE TABLE `riwayat_transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `id_member` int(11) DEFAULT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `jenis` varchar(255) NOT NULL DEFAULT 'pcs / dus',
  `harga_satuan` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `metode_bayar` varchar(255) NOT NULL DEFAULT 'cash / QRIS',
  `kasir` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `riwayat_transaksi`
--

INSERT INTO `riwayat_transaksi` (`id_transaksi`, `tanggal`, `id_member`, `nama_produk`, `qty`, `jenis`, `harga_satuan`, `total`, `metode_bayar`, `kasir`) VALUES
(6, '2026-02-22 01:10:27', NULL, 'Asus Tuff A15', 5, 'pcs', 10000000, 50000000, 'cash', 'Agus Setiawan'),
(7, '2026-02-22 01:54:17', NULL, 'Asus Tuff A15', 1, 'dus', 13000000, 13000000, 'cash', 'Fatih'),
(8, '2026-02-25 06:14:48', NULL, 'Asus VivoBook A422U', 1, 'dus', 13000000, 13000000, 'cash', 'Fatih'),
(9, '2026-02-25 06:15:36', NULL, 'Pensil 2b', 1, 'pcs', 2500, 2500, 'cash', 'Fatih'),
(10, '2026-02-25 06:16:53', NULL, 'Redmi Note 13 Pro 5G', 1, 'dus', 5700000, 5700000, 'cash', 'Fatih'),
(11, '2026-03-06 10:48:54', NULL, 'Redmi Note 13 Pro 5G', 1, 'pcs', 5700000, 5700000, 'cash', 'Fatih'),
(12, '2026-03-06 11:12:25', NULL, 'Pensil 2b', 30, 'dus', 30000, 900000, 'cash', 'Fatih'),
(13, '2026-03-06 11:12:38', NULL, 'ROG 9', 1, 'dus', 1000000, 1000000, 'cash', 'Fatih'),
(14, '2026-03-06 11:12:50', NULL, 'Redmi 9C', 1, 'dus', 1400000, 1400000, 'cash', 'Fatih'),
(15, '2026-03-06 11:12:59', NULL, 'Asus Tuff A15', 1, 'dus', 16000000, 16000000, 'cash', 'Fatih'),
(16, '2026-03-06 11:13:16', NULL, 'Buku belajar dasar HTML, CSS dan Java Script', 25, 'dus', 10000, 250000, 'cash', 'Fatih'),
(17, '2026-03-06 11:15:18', NULL, 'Iphone 15 Pro', 3, 'dus', 17000000, 51000000, 'cash', 'Fatih'),
(18, '2026-03-06 11:15:30', NULL, 'Iphone 17 Pro', 7, 'dus', 25000000, 175000000, 'cash', 'Fatih'),
(19, '2026-03-06 11:15:33', NULL, 'Iphone 17 Pro', 7, 'dus', 25000000, 175000000, 'cash', 'Fatih'),
(20, '2026-03-06 11:15:52', NULL, 'Pop Ice Cokelat', 7, 'dus', 12000, 84000, 'cash', 'Fatih'),
(21, '2026-03-06 11:16:07', NULL, 'Asus VivoBook A422U', 6, 'pcs', 10000000, 60000000, 'cash', 'Fatih'),
(22, '2026-03-06 11:16:22', NULL, 'Pensil 2b', 67, 'dus', 30000, 2010000, 'cash', 'Fatih'),
(23, '2026-03-09 11:02:38', NULL, 'Iphone 17 Pro', 1, 'pcs', 20000000, 20000000, 'cash', 'Fatih');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_barang` (`nama_barang`);

--
-- Indeks untuk tabel `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `riwayat_transaksi`
--
ALTER TABLE `riwayat_transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT untuk tabel `riwayat_transaksi`
--
ALTER TABLE `riwayat_transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
