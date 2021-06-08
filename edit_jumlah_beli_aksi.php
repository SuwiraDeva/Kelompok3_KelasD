<?php 
// START MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
require_once ("config.php");
// FINISH MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER

// PANGGIL FILE CEK STATUS LOGIN
include "cek_status_login.php";

// START PENGAMBILAN DATA BARANG & CART DI DATABASE BERDASARKAN ID BARANG
$id_barang = mysqli_real_escape_string($link,strip_tags($_POST['id_barang']));
$jumlah_beli = mysqli_real_escape_string($link,strip_tags($_POST['jumlah_beli']));
$data_barang = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM cart INNER JOIN barang ON cart.id_barang = barang.id_barang WHERE id_user='$id_user' "));

if ($jumlah_beli == "" || $jumlah_beli == 0) { // CEK JIKA JUMLAH BELI MASIH KOSONG ATAU DIBAWAH DARI 1

	header("location:edit_jumlah_beli.php?id_barang=".$id_barang."&status=error&keterangan=KOLOM JUMLAH BELI TIDAK BOLEH KOSONG !");

}else if ($jumlah_beli > $data_barang['stok']) { // CEK JIKA JUMLAH BELI LEBIH BESAR DARI STOK YANG ADA

	header("location:edit_jumlah_beli.php?id_barang=".$id_barang."&status=error&keterangan=STOK BARANG TIDAK CUKUP !");
}else{

	// START PROSES UPDATE JUMLAH BELI BARANG DI TABEL CART DI DATABASE
	mysqli_query($link, "UPDATE cart SET jumlah='$jumlah_beli' WHERE id_barang='$id_barang' AND id_user='$id_user' ");
	// FINISH PROSES UPDATE JUMLAH BELI BARANG DI TABEL CART DI DATABASE

	// START PROSES REDIRECT KE HALAMAN CART & TAMPILKAN ALERT SUKSES JIKA PROSES UPDATE JUMLAH BELI KE DALAM DATABASE SELESAI
    header("location:cart.php?status=sukses&keterangan=JUMLAH BELI - ".$data_barang['nama_barang']." BERHASIL DI UPDATE !");
    // FINISH ROSES REDIRECT KE HALAMAN CART & TAMPILKAN ALERT SUKSES JIKA PROSES UPDATE JUMLAH BELI KE DALAM DATABASE SELESAI
}
?>