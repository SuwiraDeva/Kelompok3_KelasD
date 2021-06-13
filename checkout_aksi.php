<?php
// START MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
require_once ("config.php");
// FINISH MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER

// PANGGIL FILE CEK STATUS LOGIN
include "cek_status_login.php";

// START DEKLARASI VARIABEL INPUT PADA HALAMAN CHECKOUT
$nama_penerima = mysqli_real_escape_string($link,strip_tags($_POST['nama_penerima']));
$no_hp = mysqli_real_escape_string($link,strip_tags(bersihkan_angka($_POST['no_hp'])));
$alamat = mysqli_real_escape_string($link,strip_tags($_POST['alamat']));
$total_ongkir = mysqli_real_escape_string($link,strip_tags(bersihkan_angka($_POST['total_ongkir'])));
// FINISH DEKLARASI VARIABEL INPUT PADA HALAMAN CHECKOUT

// START VALIDASI KOLOM DATA  APAKAH SUDAH TERISI ATAU BELUM 
if ($nama_penerima == "") {
    header("location:tambah_barang.php?status=error&keterangan=ANDA WAJIB MENGISI KOLOM NAMA PENERIMA / PEMESAN");
}else if ($no_hp == "") {
    header("location:tambah_barang.php?status=error&keterangan=ANDA WAJIB MENGISI KOLOM NOMOR HP AKTIF");
}else if ($alamat == "") {
    header("location:tambah_barang.php?status=error&keterangan=ANDA WAJIB MENGISI KOLOM ALAMAT LENGKAP PENGIRIMAN");
}else{
     // START PROSES MEMASUKAN DATA YANG DI INPUT USER DALAM DATABASE
    $id_pesanan = "INV".date('d').date('m').date('Y').date('H').date('i').date('s');
    $tanggal_lengkap = date('d')."-".date('m')."-".date('Y');
    $total_bayar = 0;
        $query_barang_cart = mysqli_query($link,"SELECT * FROM cart INNER JOIN barang ON cart.id_barang = barang.id_barang WHERE id_user='$id_user' ");
        
        while ($cart = mysqli_fetch_assoc($query_barang_cart)) {
            $total_bayar = $total_bayar + ($cart['harga'] * $cart['jumlah']);
            $stok_update = $cart['stok'] - $cart['jumlah'];
            mysqli_query($link,"UPDATE barang SET stok='$stok_update' WHERE id_barang='$cart[id_barang]' ");
            mysqli_query($link,"DELETE FROM cart WHERE id_barang='$cart[id_barang]' AND id_user='$id_user' ");
            mysqli_query($link,"INSERT INTO pesanan_barang VALUES ('$id_pesanan', '$cart[id_barang]', '$cart[jumlah]', '$cart[harga]', '$cart[berat]') ");
            
        }

    mysqli_query($link,"INSERT INTO pesanan VALUES ('$id_pesanan', '$id_user', '$nama_penerima', '$alamat', '$tanggal_lengkap','', '1', '', '$no_hp', '$total_bayar', '$total_ongkir', '' )");
    // FINISH PROSES MEMASUKAN DATA YANG DI INPUT USER KE DALAM DATABASE

    // START PROSES REDIRECT KE HALAMAN TAMBAH BARANG & TAMPILKAN ALERT SUKSES JIKA PROSES MEMASUKAN DATA KE DALAM DATABASE SELESAI
    header("location:my_order.php?status=sukses&keterangan=CHECKOUT BERHASIL. SILAHKAN TRANSFER PEMBAYARAN !");
    // FINISH ROSES REDIRECT KE HALAMAN TAMBAH BARANG & TAMPILKAN ALERT SUKSES JIKA PROSES MEMASUKAN DATA KE DALAM DATABASE SELESAI
}
?>