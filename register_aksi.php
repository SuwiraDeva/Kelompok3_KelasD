<?php
// START MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
require_once ("config.php");
// FINISH MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER

// START DEKLARASI VARIABEL INPUT PADA HALAMAN REGISTER
$username = mysqli_real_escape_string($link,strip_tags($_POST['username']));
$nama = mysqli_real_escape_string($link,strip_tags($_POST['nama']));
$password = mysqli_real_escape_string($link,strip_tags($_POST['password']));
$confirm_password = mysqli_real_escape_string($link,strip_tags($_POST['confirm_password']));
// FINISH DEKLARASI VARIABEL INPUT PADA HALAMAN REGISTER

// START VALIDASI KOLOM DATA  APAKAH SUDAH TERISI ATAU BELUM 
if ($username == "") {
    header("location:register.php?status=error&keterangan=ANDA WAJIB MENGISI KOLOM USERNAME");
}else if ($nama == "") {
    header("location:register.php?status=error&keterangan=ANDA WAJIB MENGISI KOLOM NAMA");
}else if ($password == "") {
    header("location:register.php?status=error&keterangan=ANDA WAJIB MENGISI KOLOM PASSWORD");
}else if ($confirm_password != $password) {
    header("location:register.php?status=error&keterangan=KOLOM PASSWORD DAN KONFIRMASI PASSWORD TIDAK SAMA !");
    // FINISH VALIDASI KOLOM DATA  APAKAH SUDAH TERISI ATAU BELUM 
}else{
    // START PROSES MEMASUKAN DATA YANG DI INPUT USER KE DALAM DATABASE
    $id_user = date('d').date('m').date('Y').date('H').date('i').date('s');
    $password_hashed = password_hash($password, PASSWORD_ARGON2I);
    mysqli_query($link,"INSERT INTO user VALUES ('$id_user', '$username', '$password_hashed', '$nama','USER')");
    // FINISH PROSES MEMASUKAN DATA YANG DI INPUT USER KE DALAM DATABASE

    // START PROSES REDIRECT KE HALAMAN LOGIN & TAMPILKAN ALERT SUKSES JIKA PROSES MEMASUKAN DATA KE DALAM DATABASE SELESAI
    header("location:login.php?status=sukses&keterangan=Anda Berhasil Membuat Akun Baru ! Silahkan Login :)");
    // FINISH ROSES REDIRECT KE HALAMAN LOGIN & TAMPILKAN ALERT SUKSES JIKA PROSES MEMASUKAN DATA KE DALAM DATABASE SELESAI
}
?>