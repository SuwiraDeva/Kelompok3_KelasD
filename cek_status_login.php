<?php 
// START DEKLARASI VARIABEL ID USER DENGAN MEMANGGIL ID YANG LOGIN PADA SESSION
$id_user = $_SESSION['user_login'];
// FINISH DEKLARASI VARIABEL ID USER DENGAN MEMANGGIL ID YANG LOGIN PADA SESSION

if ($id_user == "") { // CEK APAKAH USER SUDAH LOGIN APA BELUM. JIKA BELUM REDIRECT KE LOGIN PAGE
    header("location:login.php?status=error&keterangan=Silahkan Login Terlebih Dahulu !");   
}
?>