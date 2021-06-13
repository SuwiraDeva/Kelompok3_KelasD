-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 13 Jun 2021 pada 04.50
-- Versi server: 10.3.16-MariaDB
-- Versi PHP: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id17000610_digigear`
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

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `harga`, `stok`, `keterangan`, `foto_barang`, `berat`) VALUES
('08062021223848', 'mouse', '100000', '5', 'mouse', '08062021223848', '2'),
('09062021140917', 'Headset', '150000', '5', 'Headset', '09062021140917', '3'),
('09062021141025', 'Mouse Pad', '50000', '10', 'Mouse Pad', '09062021141025', '1'),
('09062021141118', 'Chair', '500000', '3', 'Chair', '09062021141118', '10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `id_user` varchar(20) NOT NULL,
  `id_barang` varchar(20) NOT NULL,
  `jumlah` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `cart`
--

INSERT INTO `cart` (`id_user`, `id_barang`, `jumlah`) VALUES
('31052021221115', '08062021223848', '2');

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
