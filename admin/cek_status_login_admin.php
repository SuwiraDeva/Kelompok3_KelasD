<?php 
// START DEKLARASI VARIABEL ID USER DENGAN MEMANGGIL ID YANG LOGIN PADA SESSION
$id_user = $_SESSION['user_login'];
// FINISH DEKLARASI VARIABEL ID USER DENGAN MEMANGGIL ID YANG LOGIN PADA SESSION

if ($id_user == "") { // CEK APAKAH USER SUDAH LOGIN APA BELUM. JIKA BELUM REDIRECT KE LOGIN PAGE
    header("location:../login.php?status=error&keterangan=Silahkan Login Terlebih Dahulu !");
    
}else{

    // START CEK DATA USER PADA DATABASE
$cek_user = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM user WHERE id_user='$id_user' "));
// START CEK DATA USER PADA DATABASE

if ($cek_user['hak_akses'] != "ADMIN") { // CEK APAKAH USER YANG LOGIN ADALAH ADMIN. JIKA BUKAN LOGOUT DAN KEMBALI KE PAGE LOGIN
// UNSET SEMUA VARIABLE SESI
$_SESSION = array();
// HAPUS SESI
session_destroy();
    header("location:../login.php?status=error&keterangan=ANDA BUKAN ADMIN !");
}

}

$cek_order = mysqli_fetch_assoc(mysqli_query($link, "SELECT COUNT(*) as jumlah_order FROM pesanan "));

?>