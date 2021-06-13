<?php
error_reporting(0);
date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();
/* Data akun mysql (nama server, nama user, passsword, nama database) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'digigear');
/* Menyambungkan kepada database sql */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

function rupiah($angka){
    $bersihkan = preg_replace('/[^0-9\-]/', '', $angka);
    $hasil_rupiah = "Rp " . number_format($bersihkan,0,',','.');
    return $hasil_rupiah;
}

function bersihkan_angka($angka){
    $hasil_bersihkan = preg_replace('/[^0-9\-]/', '', $angka);
    return $hasil_bersihkan;
}

$direktori = "tugasdigigear/";
$direktori_admin = "tugasdigigear/admin/";
?>
