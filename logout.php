<?php
// START SESSION
session_start();
 
// UNSET SEMUA VARIABLE SESI
$_SESSION = array();

// HAPUS SESI
session_destroy();

// REDIRECT KE PAGE LOGIN
header("location:index.php?status=sukses&keterangan=LOGOUT BERHASIL !"); 
?>