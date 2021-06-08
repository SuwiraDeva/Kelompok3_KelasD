<?php
// START MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
require_once ("config.php");
// FINISH MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER

// PANGGIL FILE CEK STATUS LOGIN
include "cek_status_login.php";

// START DEKLARASI VARIABEL INPUT PADA HALAMAN MY ORDER
$id_order = mysqli_real_escape_string($link,strip_tags($_GET['id_order']));
// FINISH DEKLARASI VARIABEL INPUT PADA HALAMAN MY ORDER

mysqli_query($link,"DELETE FROM pesanan WHERE id_order='$id_order' ");
$cek_pesanan = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM pesanan WHERE id_order='$id_order' "));

$query_cek_barang_pesanan = mysqli_query($link,"SELECT * FROM pesanan_barang WHERE id_order='$id_order' ");
while($cek_barang_pesanan = mysqli_fetch_assoc($query_cek_barang_pesanan)){
	$cek_barang = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM barang WHERE id_barang='$cek_barang_pesanan[id_barang]' "));
	$jumlah_barang_final = $cek_barang['stok'] + $cek_barang_pesanan['jumlah_dipesan'];
	mysqli_query($link,"UPDATE barang SET stok='$jumlah_barang_final' WHERE id_barang='$cek_barang_pesanan[id_barang]' ");
	mysqli_query($link,"DELETE FROM pesanan_barang WHERE id_order='$id_order' ");

}

header("location:my_order.php?status=sukses&keterangan=STATUS PESANAN BERHASIL DI BATALKAN !".mysqli_error($link)); 
?>