<?php
// START MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
require_once ("config.php");
// FINISH MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER

// PANGGIL FILE CEK STATUS LOGIN
include "cek_status_login.php";


// START DEKLARASI VARIABEL INPUT PADA HALAMAN MY ORDER
$id_order = mysqli_real_escape_string($link,strip_tags($_POST['id_order']));
$keterangan_pembayaran = mysqli_real_escape_string($link,strip_tags($_POST['keterangan_pembayaran']));
$nama_file_gambar = mysqli_real_escape_string($link,strip_tags($_POST['nama_file_gambar']));
// FINISH DEKLARASI VARIABEL INPUT PADA HALAMAN MY ORDER

// START PENGAMBILAN DATA BARANG DI DATABASE BERDASARKAN ID BARANG
$data_order = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM pesanan WHERE id_order='$id_order' "));
// FINISH PENGAMBILAN DATA BARANG DI DATABASE BERDASARKAN ID BARANG

// START VALIDASI KOLOM DATA APAKAH SUDAH TERISI ATAU BELUM 
if ($keterangan_pembayaran == "") {
    header("location:konfirmasi_pembayaran.php?id_order=".$id_order."&status=error&keterangan=ANDA WAJIB MENGISI KOLOM KETERANGAN VERIFIKASI PEMBAYARAN !");
}else if ($nama_file_gambar != $data_order['foto_bukti_transfer']) {
        // JIKA GAMBAR DIGANTI
        // START PROSES VALIDASI UPLOAD FOTO / GAMBAR BARANG
$direktori = "asset/gambar_bukti_transfer/"; // Folder Penyimpanan Foto/Gambar Barang Setelah Di Upload

unlink($direktori.$data_order['foto_bukti_transfer'].'.png'); // Hapus Gambar Sebelumnya Dari Direktori

$nama_file = date('d').date('m').date('Y').date('H').date('i').date('s'); // Nama File Setelah Diupload Menggunakan Kombinasi Tanggal,Bulan,Tahun,Jam,Menit,Tahun.

$direktori_dan_nama_file = $direktori.$nama_file.'.png'; // Direktori & Nama File Yang Akan Diupload

$cek_ekstensi_file = strtolower(pathinfo(basename($_FILES["upload_gambar"]["name"]),PATHINFO_EXTENSION)); // Cek Apakah File Yang Diupload Benar File Gambar Dengan Ekstensi PNG / JPG / JPEG )

  if($cek_ekstensi_file != "png" && $cek_ekstensi_file != "jpg" && $cek_ekstensi_file != "jpeg" ) { // Jika File Bukan Gambar ( SELAIN Ekstensi PNG / JPG / JPEG )
   header("location:konfirmasi_pembayaran.php?id_order=".$id_order."&status=error&keterangan=FILE GAMBAR TIDAK VALID !".$cek_ekstensi_file); 
  } else { // Jika File Adalah Gambar ( Ekstensi PNG / JPG / JPEG )
   // FINISH PROSES VALIDASI UPLOAD FOTO / GAMBAR BARANG

    // START PROSES UPLOAD GAMBAR
    if (move_uploaded_file($_FILES["upload_gambar"]["tmp_name"], $direktori_dan_nama_file)) { // JIKA GAMBAR BERHASIL DI UPLOAD

         // START PROSES UPDATE DATA YANG DI INPUT USER & NAMA FILE GAMBAR DI DALAM DATABASE
        mysqli_query($link,"UPDATE pesanan SET keterangan_pembayaran='$keterangan_pembayaran', foto_bukti_transfer='$nama_file' WHERE id_order='$id_order' ");
        // FINISH PROSES UPDATE DATA YANG DI INPUT USER & NAMA FILE GAMBAR DI DALAM DATABASE

    // START PROSES REDIRECT KE HALAMAN MY ORDER & TAMPILKAN ALERT SUKSES JIKA PROSES MEMASUKAN DATA KE DALAM DATABASE SELESAI
    header("location:my_order.php?status=sukses&keterangan=KONFIRMASI PEMBAYARAN BERHASIL DI UPDATE !");
    // FINISH PROSES REDIRECT KE HALAMAN MY ORDER & TAMPILKAN ALERT SUKSES JIKA PROSES MEMASUKAN DATA KE DALAM DATABASE SELESAI


    } else { // JIKA GAMBAR GAGAL DI UPLOAD
    header("location:konfirmasi_pembayaran.php?id_order=".$id_order."&status=error&keterangan=FOTO/GAMBAR BARANG GAGAL DIUPLOAD !"); 
    }
    // FINISH PROSES UPLOAD GAMBAR
  }
    
     // FINISH VALIDASI APAKAH GAMBAR DIGANTI ATAU DIKOSONGKAN
}else{
    // START PROSES UPDATE DATA YANG DI INPUT USER & NAMA FILE GAMBAR DI DALAM DATABASE
     mysqli_query($link,"UPDATE pesanan SET keterangan_pembayaran='$keterangan_pembayaran' WHERE id_order='$id_order' ");
    // FINISH PROSES UPDATE DATA YANG DI INPUT USER & NAMA FILE GAMBAR DI DALAM DATABASE
    
    // START PROSES REDIRECT KE HALAMAN MY ORDER & TAMPILKAN ALERT SUKSES JIKA PROSES MEMASUKAN DATA KE DALAM DATABASE SELESAI
    header("location:my_order.php?status=sukses&keterangan=KONFIRMASI PEMBAYARAN BERHASIL DI UPDATE !");
    // FINISH ROSES REDIRECT KE HALAMAN MY ORDER & TAMPILKAN ALERT SUKSES JIKA PROSES MEMASUKAN DATA KE DALAM DATABASE SELESAI
}
?>