<?php
// START MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
require_once ("config.php");
// FINISH MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER

// START DEKLARASI VARIABEL INPUT PADA HALAMAN LOGIN
$username = mysqli_real_escape_string($link,strip_tags($_POST['username']));
$password = mysqli_real_escape_string($link,strip_tags($_POST['password']));
// FINISH DEKLARASI VARIABEL INPUT PADA HALAMAN LOGIN

// VALIDASI KOLOM USERNAME DAN PASSWORD APAKAH SUDAH TERISI ATAU BELUM
if($username != "" && $password != ""){
    
    // CHECK USERNAME DI DATABASE APAKAH ADA YANG COCOK
    $cek_username = mysqli_fetch_assoc(mysqli_query($link,"SELECT COUNT(*) as jumlah FROM user WHERE username='$username'"));
    if($cek_username['jumlah'] != 0){
        $data_user = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM user WHERE username='$username'"));

        // CHECK PASSWORD YANG DIINPUT APAKAH SUDAH SESUAI DENGAN HASIL HASHING DI DATABASE
        if(password_verify($password, $data_user['password'])){

            // LOGIN BERHASIL - REDIRECT KE HALAMAN UTAMA
            session_start();
            $_SESSION['user_login'] = $data_user['id_user'];

            if ($data_user['hak_akses'] == "USER") {
               header("location:index.php?status=sukses&keterangan=Selamat Datang ".$data_user['nama']." !");
            }else if ($data_user['hak_akses'] == "ADMIN") {
               header("location:admin/daftar_order.php?status=sukses&keterangan=Selamat Datang Admin ".$data_user['nama']." !");
            }
            
        }else{
            // LOGIN GAGAL - PASSWORD SALAH
            header("location:login.php?status=error&keterangan=PASSWORD SALAH !");
        }
    
    }else{ // LOGIN GAGAL - USERNAME TIDAK DITEMUKAN
        header("location:login.php?status=error&keterangan=USERNAME TIDAK DITEMUKAN !");
    }
}else{ // LOGIN GAGAL - KOLOM USERNAME / PASSWORD MASIH KOSONG
    header("location:login.php?status=error&keterangan=KOLOM USERNAME ATAU PASSWORD MASIH KOSOSNG !");
}
?>