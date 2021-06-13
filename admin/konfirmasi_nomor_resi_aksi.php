<?php
// START MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
require_once ("../config.php");
// FINISH MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER

// PANGGIL FILE CEK STATUS LOGIN
include "cek_status_login_admin.php";

// START DEKLARASI VARIABEL INPUT PADA HALAMAN MY ORDER
$id_order = mysqli_real_escape_string($link,strip_tags($_POST['id_order']));
$no_resi_kurir = mysqli_real_escape_string($link,strip_tags($_POST['no_resi_kurir']));
// FINISH DEKLARASI VARIABEL INPUT PADA HALAMAN MY ORDER

if ($no_resi_kurir == "") {
	header("location:konfirmasi_nomor_resi.php?id_order=".$id_order."&status=error&keterangan=KOLOM NOMOR RESI MASIH KOSONG !"); 
}else{
	mysqli_query($link,"UPDATE pesanan SET status='3', resi_kurir='$no_resi_kurir' WHERE id_order='$id_order' ");
header("location:daftar_order.php?status=sukses&keterangan=STATUS NOMOR RESI PENGIRIMAN BERHASIL DI UPDATE !"); 
}

?>