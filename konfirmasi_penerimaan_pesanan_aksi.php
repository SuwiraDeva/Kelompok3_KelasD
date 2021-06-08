<?php
// START MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
require_once ("config.php");
// FINISH MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER

// PANGGIL FILE CEK STATUS LOGIN
include "cek_status_login.php";

// START DEKLARASI VARIABEL INPUT PADA HALAMAN MY ORDER
$id_order = mysqli_real_escape_string($link,strip_tags($_GET['id_order']));
// FINISH DEKLARASI VARIABEL INPUT PADA HALAMAN MY ORDER

mysqli_query($link,"UPDATE pesanan SET status='4' WHERE id_order='$id_order' ");

header("location:my_order.php?status=sukses&keterangan=STATUS PENERIMAAN PESANAN BERHASIL DI KONFIRMASi !"); 
?>