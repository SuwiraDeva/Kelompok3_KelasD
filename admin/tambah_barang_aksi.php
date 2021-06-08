<?php
// START MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
require_once ("../config.php");
// FINISH MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER

// PANGGIL FILE CEK STATUS LOGIN
include "cek_status_login_admin.php";

// START DEKLARASI VARIABEL INPUT PADA HALAMAN TAMBAH BARANG
$nama_barang = mysqli_real_escape_string($link,strip_tags($_POST['nama_barang']));
$harga_barang = mysqli_real_escape_string($link,strip_tags(bersihkan_angka($_POST['harga_barang'])));
$stok_barang = mysqli_real_escape_string($link,strip_tags(bersihkan_angka($_POST['stok_barang'])));
$deskripsi = mysqli_real_escape_string($link,strip_tags($_POST['deskripsi']));
$berat = mysqli_real_escape_string($link,strip_tags($_POST['berat']));
// FINISH DEKLARASI VARIABEL INPUT PADA HALAMAN TAMBAH BARANG

// START VALIDASI KOLOM DATA  APAKAH SUDAH TERISI ATAU BELUM 
if ($nama_barang == "") {
    header("location:tambah_barang.php?status=error&keterangan=ANDA WAJIB MENGISI KOLOM NAMA BARANG");
}else if ($harga_barang == "") {
    header("location:tambah_barang.php?status=error&keterangan=ANDA WAJIB MENGISI KOLOM HARGA BARANG");
}else if ($stok_barang == "") {
    header("location:tambah_barang.php?status=error&keterangan=ANDA WAJIB MENGISI KOLOM STOK BARANG");
}else if ($deskripsi == "") {
    header("location:tambah_barang.php?status=error&keterangan=ANDA WAJIB MENGISI KOLOM DESKRIPSI BARANG");
    // FINISH VALIDASI KOLOM DATA  APAKAH SUDAH TERISI ATAU BELUM 
}else if ($berat == "" || $berat == 0) {
    header("location:tambah_barang.php?status=error&keterangan=ANDA WAJIB MENGISI KOLOM BERAT BARANG");
}else if ($_FILES["upload_gambar"]["error"] == 4) {
    header("location:tambah_barang.php?status=error&keterangan=ANDA WAJIB MEMILIH SATU FOTO/GAMBAR BARANG");
    // FINISH VALIDASI DATA APAKAH SUDAH TERISI ATAU BELUM 
}else{
// START PROSES VALIDASI UPLOAD FOTO / GAMBAR BARANG
$direktori = "../asset/gambar_barang/"; // Folder Penyimpanan Foto/Gambar Barang Setelah Di Upload

$nama_file = date('d').date('m').date('Y').date('H').date('i').date('s'); // Nama File Setelah Diupload Menggunakan Kombinasi Tanggal,Bulan,Tahun,Jam,Menit,Tahun.

$direktori_dan_nama_file = $direktori.$nama_file.'.png'; // Direktori & Nama File Yang Akan Diupload

$cek_ekstensi_file = strtolower(pathinfo(basename($_FILES["upload_gambar"]["name"]),PATHINFO_EXTENSION)); // Cek Apakah File Yang Diupload Benar File Gambar Dengan Ekstensi PNG / JPG / JPEG )

  if($cek_ekstensi_file != "png" && $cek_ekstensi_file != "jpg" && $cek_ekstensi_file != "jpeg" ) { // Jika File Bukan Gambar ( SELAIN Ekstensi PNG / JPG / JPEG )
   header("location:tambah_barang.php?status=error&keterangan=FILE GAMBAR TIDAK VALID !"); 
  } else { // Jika File Adalah Gambar ( Ekstensi PNG / JPG / JPEG )
   // FINISH PROSES VALIDASI UPLOAD FOTO / GAMBAR BARANG

    // START PROSES UPLOAD GAMBAR
    if (move_uploaded_file($_FILES["upload_gambar"]["tmp_name"], $direktori_dan_nama_file)) { // JIKA GAMBAR BERHASIL DI UPLOAD

         // START PROSES MEMASUKAN DATA YANG DI INPUT USER & NAMA FILE GAMBAR KE DALAM DATABASE
    $id_barang = date('d').date('m').date('Y').date('H').date('i').date('s');
    mysqli_query($link,"INSERT INTO barang VALUES ('$id_barang', '$nama_barang', '$harga_barang', '$stok_barang', '$deskripsi','$nama_file', '$berat')");
    // FINISH PROSES MEMASUKAN DATA YANG DI INPUT USER & NAMA FILE GAMBAR KE DALAM DATABASE

    // START PROSES REDIRECT KE HALAMAN TAMBAH BARANG & TAMPILKAN ALERT SUKSES JIKA PROSES MEMASUKAN DATA KE DALAM DATABASE SELESAI
    header("location:tambah_barang.php?status=sukses&keterangan=DATA BARANG BERHASIL DISIMPAN !");
    // FINISH ROSES REDIRECT KE HALAMAN TAMBAH BARANG & TAMPILKAN ALERT SUKSES JIKA PROSES MEMASUKAN DATA KE DALAM DATABASE SELESAI

    } else { // JIKA GAMBAR GAGAL DI UPLOAD
    header("location:tambah_barang.php?status=error&keterangan=FOTO/GAMBAR BARANG GAGAL DIUPLOAD !"); 
    }
    // FINISH PROSES UPLOAD GAMBAR
  }
}
?>