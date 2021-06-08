<?php
// START MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
require_once ("config.php");
// FINISH MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER

// START DEKLARASI VARIABEL INPUT PADA HALAMAN UTAMA GET METHOD
$id_barang = mysqli_real_escape_string($link,strip_tags($_GET['id_barang']));
// FINISH DEKLARASI VARIABEL INPUT PADA HALAMAN UTAMA GET METHOD

// START DEKLARASI VARIABEL ID USER DENGAN MEMANGGIL ID YANG LOGIN PADA SESSION
$id_user = $_SESSION['user_login'];
// FINISH DEKLARASI VARIABEL ID USER DENGAN MEMANGGIL ID YANG LOGIN PADA SESSION

if ($id_user == "") { // CEK APAKAH USER SUDAH LOGIN APA BELUM. JIKA BELUM REDIRECT KE LOGIN PAGE
    header("location:login.php?status=error&keterangan=Silahkan Login Terlebih Dahulu !");
    
}else{// JIKA USER SUDAH LOGIN
// START CEK DATA BARANG DI DATABASE BERDASARKAN ID BARANG
$data_barang = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM barang WHERE id_barang='$id_barang' "));
// FINISH CEK DATA BARANG DI DATABASE BERDASARKAN ID BARANG

// START CEK APAKAH DATA BARANG ADA DI TABEL CART BERDASARKAN ID BARANG & ID USER
$cek_cart = mysqli_fetch_assoc(mysqli_query($link,"SELECT COUNT(*) as jumlah_barang_di_cart FROM cart WHERE id_barang='$id_barang' AND id_user='$id_user' "));
// FINISH CEK APAKAH DATA BARANG ADA DI TABEL CART BERDASARKAN ID BARANG & ID USER

// START CEK DATA BARANG DI TABEL CART BERDASARKAN ID BARANG & ID USER
$data_cart = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM cart WHERE id_barang='$id_barang' AND id_user='$id_user' "));
// FINISH CEK DATA BARANG DI TABEL CART BERDASARKAN ID BARANG & ID USER

if ($cek_cart['jumlah_barang_di_cart'] == 0) { // JIKA BARANG BELUM ADA DI CART USER

    // START PROSES MEMASUKAN DATA BARANG KEDALAM TABEL CART DI DATABASE
    mysqli_query($link,"INSERT INTO cart VALUES ('$id_user', '$id_barang', '1')");
    // FINISH PROSES MEMASUKAN DATA BARANG KEDALAM TABEL CART DI DATABASE

}else{ // JIKA BARANG SUDAH ADA DI CART USER

    // CEK & TAMBAHKAN 1 PADA JUMLAH BARANG DI CART SAAT INI
    $jumlah_total = $data_cart['jumlah'] + 1;

    // START PROSES UPDATE JUMLAH BARANG DALAM TABEL CART DI DATABASE
    mysqli_query($link,"UPDATE cart SET jumlah='$jumlah_total' WHERE id_barang='$id_barang' AND id_user='$id_user' ");
    // FINISH PROSES UPDATE JUMLAH BARANG DALAM TABEL CART DI DATABASE

}

    // START PROSES REDIRECT KE HALAMAN CART & TAMPILKAN ALERT SUKSES JIKA PROSES MEMASUKAN DATA KE DALAM DATABASE SELESAI
    header("location:shop.php?status=sukses&keterangan=".$data_barang['nama_barang']." Berhasil Dimasukan Dalam Keranjang :)");
    // FINISH ROSES REDIRECT KE HALAMAN CART & TAMPILKAN ALERT SUKSES JIKA PROSES MEMASUKAN DATA KE DALAM DATABASE SELESAI

}
?>