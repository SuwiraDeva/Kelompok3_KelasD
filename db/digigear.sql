-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Jun 2021 pada 15.43
-- Versi server: 10.4.19-MariaDB
-- Versi PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `digigear`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` varchar(20) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `harga` varchar(10) NOT NULL,
  `stok` varchar(10) NOT NULL,
  `keterangan` text NOT NULL,
  `foto_barang` varchar(20) NOT NULL,
  `berat` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `id_user` varchar(20) NOT NULL,
  `id_barang` varchar(20) NOT NULL,
  `jumlah` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_order` varchar(20) NOT NULL,
  `id_user` varchar(20) NOT NULL,
  `nama_penerima` text NOT NULL,
  `alamat_lengkap` text NOT NULL,
  `tanggal_pesanan` text NOT NULL,
  `resi_kurir` text NOT NULL,
  `status` text NOT NULL,
  `keterangan_pembayaran` text NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `total_bayar` varchar(15) NOT NULL,
  `ongkir` varchar(15) NOT NULL,
  `foto_bukti_transfer` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan_barang`
--

CREATE TABLE `pesanan_barang` (
  `id_order` varchar(20) NOT NULL,
  `id_barang` varchar(20) NOT NULL,
  `jumlah_dipesan` varchar(5) NOT NULL,
  `harga_dipesan` varchar(15) NOT NULL,
  `berat_barang` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekening`
--

CREATE TABLE `rekening` (
  `id` varchar(1) NOT NULL,
  `detail_rekening` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `rekening`
--

INSERT INTO `rekening` (`id`, `detail_rekening`) VALUES
('1', 'Rekening BRI\r\nI Nyoman Suwira Deva\r\n12873127380123123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` varchar(20) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `nama` text NOT NULL,
  `hak_akses` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `hak_akses`) VALUES
('08062021132326', 'insd', '$argon2i$v=19$m=65536,t=4,p=1$VUlYL3BCUTJrQnNZUlhnVA$LvpARmL4Q/tH7c6kTn50Ky+0sSmEFhvdtN884V2jTw0', 'deva', 'USER'),
('31052021221115', 'admin', '$argon2i$v=19$m=65536,t=4,p=1$UlRkbVZFanpWR2Vob0FMUQ$QC5VqLNFODxXxJibVhWz8/P8aJcfdmvaeZrxx2rA6w0', 'admin', 'ADMIN');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
