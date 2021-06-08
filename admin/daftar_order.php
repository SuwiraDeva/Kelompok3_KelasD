<?php 
// START MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
require_once ("../config.php");
// FINISH MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Order - DigiGear Store Admin</title>

    <!-- CSS ASSET -->
    <link rel="stylesheet" href="../asset/css/aos.css">
    <link rel="preconnect" href="../asset/css/css2.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/style.css">
    <link rel="stylesheet" href="../asset/css/sweetalert2.min.css" />
    <!-- CSS ASSET -->

    <!-- JAVASCRIPT ASSET -->
    <script src="../asset/js/aos.js"></script>
    <script src="../asset/js/jquery.min.js"></script>
    <script src="../asset/js/script.js"></script>
    <script src="../asset/js/sweetalert2.min.js"></script>
       <script src="../asset/js/font-awesome3769096239.js"></script>
    <!-- JAVASCRIPT ASSET -->

</head>
<body>
 <!-- ALERT FLEKSIBEL YANG MENERIMA STATUS DARI FILE AKSI -->
<?php if($_GET['status'] == "error"){?>
<script>
window.history.replaceState({}, document.title, "/" + "<?php echo $direktori_admin; ?>daftar_order.php");
Swal.fire({
type: 'error',
title: "<?php echo $_GET['keterangan']; ?>"
})
</script>
<?php }else if($_GET['status'] == "sukses"){ ?>
<script>
window.history.replaceState({}, document.title, "/" + "<?php echo $direktori_admin; ?>daftar_order.php");
Swal.fire({
type: 'success',
title: "<?php echo $_GET['keterangan']; ?>"
})
</script>
<?php } ?>
 <!-- ALERT FLEKSIBEL YANG MENERIMA STATUS DARI FILE AKSI -->

<!-- PANGGIL FILE HEADER.PHP -->
<?php include("header_admin.php"); ?>
<!-- PANGGIL FILE HEADER.PHP -->


<!-- daftar Barang section starts  -->

<section class="shop" id="shop">

    <h1 class="heading">Daftar Order </h1>
    
    <div class="box-container">
    
        <?php $query_pesanan = mysqli_query($link,"SELECT * FROM pesanan ORDER BY tanggal_pesanan ");
        while ($pesanan = mysqli_fetch_assoc($query_pesanan)) {
        ?>
       
        <div class="box" >
            <font style="font-size: 16px; color: purple;">ID Pesanan :</font>
            <h3><?php echo $pesanan['id_order']; ?></h3>
            <hr><br>
            <font style="font-size: 16px; color: red;">Nama Pemesan :</font><br>
            <font style="font-size: 20px; color: gray;"><?php echo $pesanan['nama_penerima']; ?></font>
            <hr><br>
            <font style="font-size: 16px; color: orange;">Tanggal Pemesanan :</font>
            <h3><?php echo $pesanan['tanggal_pesanan']; ?></h3>
            <hr><br>
            <font style="font-size: 16px; color: green;">Total Pembayaran :</font>
            <h3><?php echo rupiah($pesanan['total_bayar'] + $pesanan['ongkir']); ?></h3>
            <hr><br>
            <font style="font-size: 16px; color: blue;">Status Pesanan :</font>
            <div style="text-align:center; font-size:20px; color: white; padding: 10px; background-color: dodgerblue;">
                <?php
                $status_pesanan = $pesanan['status'];
                if ($status_pesanan == 1) {
                    echo "MENUNGGU KONFIRMASI PENERIMAAN PEMBAYARAN DARI SELLER";
                }else if ($status_pesanan == 2) {
                    echo "PEMBAYARAN DI TERIMA<br>PESANAN DIPROSES";
                }else if ($status_pesanan == 3) {
                    echo "PESANAN DALAM PENGIRIMAN<br>PT POS INDONESIA<br>No Resi : ".$pesanan['resi_kurir'];
                }else if ($status_pesanan == 4) {
                    echo "BARANG DI TERIMA<b>PESANAN SELESAI";
                }
                 ?>
            </div>

            <a style="cursor: pointer;" href="my_order_detail_admin.php?id_order=<?php echo $pesanan['id_order']; ?>"><button class="btn">Detail Pesanan</button></a>

                   </div>
        <?php } ?>
          

    </div>
    </section>
    
<!-- daftar Barang section ends -->


<!-- PANGGIL FILE FOOTER.PHP -->
<?php include("../footer.php"); ?>
<!-- PANGGIL FILE FOOTER.PHP -->


<!-- initializing aos  -->
<script>
    AOS.init({
        delay:400,
        duration:1000
    })


function hapus_data_barang(id_barang, nama_barang){
   Swal.fire({
  title: 'Hapus Barang : '+nama_barang+' ?',
  text: "",
  type: 'question',
  showCancelButton: true,
  cancelButtonText: 'Tidak',
  confirmButtonText: 'Ya'
}).then((result) => {
  if (result.value) {
location.href="hapus_data_barang_aksi.php?id_barang="+id_barang;
}
})

}

</script>

</body>
</html>