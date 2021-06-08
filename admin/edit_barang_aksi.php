<?php
// START MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
require_once ("../config.php");
// FINISH MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER

// PANGGIL FILE CEK STATUS LOGIN
include "cek_status_login_admin.php";

// START DEKLARASI VARIABEL INPUT PADA HALAMAN EDIT BARANG
$id_barang = mysqli_real_escape_string($link,strip_tags($_POST['id_barang']));
$nama_barang = mysqli_real_escape_string($link,strip_tags($_POST['nama_barang']));
$harga_barang = mysqli_real_escape_string($link,strip_tags(bersihkan_angka($_POST['harga_barang'])));
$stok_barang = mysqli_real_escape_string($link,strip_tags(bersihkan_angka($_POST['stok_barang'])));
$deskripsi = mysqli_real_escape_string($link,strip_tags($_POST['deskripsi']));
$nama_file_gambar = mysqli_real_escape_string($link,strip_tags($_POST['nama_file_gambar']));
$berat = mysqli_real_escape_string($link,strip_tags(bersihkan_angka($_POST['berat'])));
// FINISH DEKLARASI VARIABEL INPUT PADA HALAMAN EDIT BARANG

// START PENGAMBILAN DATA BARANG DI DATABASE BERDASARKAN ID BARANG
$data_barang = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM barang WHERE id_barang='$id_barang' "));
// FINISH PENGAMBILAN DATA BARANG DI DATABASE BERDASARKAN ID BARANG

// START VALIDASI KOLOM DATA APAKAH SUDAH TERISI ATAU BELUM 
if ($nama_barang == "") {
    header("location:edit_barang.php?id_barang=".$data_barang['id_barang']."&status=error&keterangan=ANDA WAJIB MENGISI KOLOM NAMA BARANG");
}else if ($harga_barang == "") {
    header("location:edit_barang.php?id_barang=".$data_barang['id_barang']."&status=error&keterangan=ANDA WAJIB MENGISI KOLOM HARGA BARANG");
}else if ($stok_barang == "") {
    header("location:edit_barang.php?id_barang=".$data_barang['id_barang']."&status=error&keterangan=ANDA WAJIB MENGISI KOLOM STOK BARANG");
}else if ($berat == "" || $berat == 0) {
    header("location:tambah_barang.php?status=error&keterangan=ANDA WAJIB MENGISI KOLOM BERAT BARANG");
}else if ($deskripsi == "") {
    header("location:edit_barang.php?id_barang=".$data_barang['id_barang']."&status=error&keterangan=ANDA WAJIB MENGISI KOLOM DESKRIPSI BARANG");
    // FINISH VALIDASI KOLOM DATA APAKAH SUDAH TERISI ATAU BELUM 

    // START VALIDASI APAKAH GAMBAR DIGANTI ATAU DIKOSONGKAN
}else if ($nama_file_gambar != $data_barang['foto_barang']) {
    if ($_FILES["upload_gambar"]["error"] == 4) {
    header("location:edit_barang.php?id_barang=".$data_barang['id_barang']."&status=error&keterangan=ANDA WAJIB MEMILIH SATU FOTO/GAMBAR BARANG"); 
    }else{
        // JIKA GAMBAR DIGANTI
        // START PROSES VALIDASI UPLOAD FOTO / GAMBAR BARANG
$direktori = "../asset/gambar_barang/"; // Folder Penyimpanan Foto/Gambar Barang Setelah Di Upload

unlink($direktori.$data_barang['foto_barang'].'.png'); // Hapus Gambar Sebelumnya Dari Direktori

$nama_file = date('d').date('m').date('Y').date('H').date('i').date('s'); // Nama File Setelah Diupload Menggunakan Kombinasi Tanggal,Bulan,Tahun,Jam,Menit,Tahun.

$direktori_dan_nama_file = $direktori.$nama_file.'.png'; // Direktori & Nama File Yang Akan Diupload

$cek_ekstensi_file = strtolower(pathinfo(basename($_FILES["upload_gambar"]["name"]),PATHINFO_EXTENSION)); // Cek Apakah File Yang Diupload Benar File Gambar Dengan Ekstensi PNG / JPG / JPEG )

  if($cek_ekstensi_file != "png" && $cek_ekstensi_file != "jpg" && $cek_ekstensi_file != "jpeg" ) { // Jika File Bukan Gambar ( SELAIN Ekstensi PNG / JPG / JPEG )
   header("location:edit_barang.php?id_barang=".$data_barang['id_barang']."&status=error&keterangan=FILE GAMBAR TIDAK VALID !".$cek_ekstensi_file); 
  } else { // Jika File Adalah Gambar ( Ekstensi PNG / JPG / JPEG )
   // FINISH PROSES VALIDASI UPLOAD FOTO / GAMBAR BARANG

    // START PROSES UPLOAD GAMBAR
    if (move_uploaded_file($_FILES["upload_gambar"]["tmp_name"], $direktori_dan_nama_file)) { // JIKA GAMBAR BERHASIL DI UPLOAD

         // START PROSES UPDATE DATA YANG DI INPUT USER & NAMA FILE GAMBAR DI DALAM DATABASE
        mysqli_query($link,"UPDATE barang SET nama_barang='$nama_barang', harga='$harga_barang', stok='$stok_barang', keterangan='$deskripsi', foto_barang='$nama_file', berat='$berat' WHERE id_barang='$id_barang' ");
        // FINISH PROSES UPDATE DATA YANG DI INPUT USER & NAMA FILE GAMBAR DI DALAM DATABASE

    // START PROSES REDIRECT KE HALAMAN EDIT BARANG & TAMPILKAN ALERT SUKSES JIKA PROSES MEMASUKAN DATA KE DALAM DATABASE SELESAI
    header("location:edit_barang.php?id_barang=".$data_barang['id_barang']."&status=sukses&keterangan=DATA BARANG BERHASIL DI PERBAHARUI !");
    // FINISH PROSES REDIRECT KE HALAMAN EDIT BARANG & TAMPILKAN ALERT SUKSES JIKA PROSES MEMASUKAN DATA KE DALAM DATABASE SELESAI


    } else { // JIKA GAMBAR GAGAL DI UPLOAD
    header("location:edit_barang.php?id_barang=".$data_barang['id_barang']."&status=error&keterangan=FOTO/GAMBAR BARANG GAGAL DIUPLOAD !"); 
    }
    // FINISH PROSES UPLOAD GAMBAR
  }
    } 
     // FINISH VALIDASI APAKAH GAMBAR DIGANTI ATAU DIKOSONGKAN
}else{
    // START PROSES UPDATE DATA YANG DI INPUT USER & NAMA FILE GAMBAR DI DALAM DATABASE
    mysqli_query($link,"UPDATE barang SET nama_barang='$nama_barang', harga='$harga_barang', stok='$stok_barang', keterangan='$deskripsi', berat='$berat' WHERE id_barang='$id_barang' ");
    // FINISH PROSES UPDATE DATA YANG DI INPUT USER & NAMA FILE GAMBAR DI DALAM DATABASE
    
    // START PROSES REDIRECT KE HALAMAN EDIT BARANG & TAMPILKAN ALERT SUKSES JIKA PROSES MEMASUKAN DATA KE DALAM DATABASE SELESAI
    header("location:edit_barang.php?id_barang=".$data_barang['id_barang']."&status=sukses&keterangan=DATA BARANG BERHASIL DI PERBAHARUI !");
    // FINISH ROSES REDIRECT KE HALAMAN EDIT BARANG & TAMPILKAN ALERT SUKSES JIKA PROSES MEMASUKAN DATA KE DALAM DATABASE SELESAI
}
?>