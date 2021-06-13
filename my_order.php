<?php 
// START MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
require_once ("config.php");
// FINISH MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER

// PANGGIL FILE CEK STATUS LOGIN
include "cek_status_login.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order - DigiGear Store</title>

    <!-- CSS ASSET -->
    <link rel="stylesheet" href="asset/css/aos.css">
    <link rel="preconnect" href="asset/css/css2.css" rel="stylesheet">
    <link rel="stylesheet" href="asset/css/style.css">
    <link rel="stylesheet" href="asset/css/sweetalert2.min.css" />
    <!-- CSS ASSET -->

    <!-- JAVASCRIPT ASSET -->
    <script src="asset/js/aos.js"></script>
    <script src="asset/js/jquery.min.js"></script>
    <script src="asset/js/script.js"></script>
    <script src="asset/js/sweetalert2.min.js"></script>
       <script src="asset/js/font-awesome3769096239.js"></script>
    <!-- JAVASCRIPT ASSET -->

</head>
<body>
<!-- ALERT FLEKSIBEL YANG MENERIMA STATUS DARI FILE AKSI -->
<?php if($_GET['status'] == "error"){?>
<script>
window.history.replaceState({}, document.title, "/" + "<?php echo $direktori; ?>my_order.php");
Swal.fire({
type: 'error',
title: "<?php echo $_GET['keterangan']; ?>"
})
</script>
<?php }else if($_GET['status'] == "sukses"){ ?>
<script>
window.history.replaceState({}, document.title, "/" + "<?php echo $direktori; ?>my_order.php");
Swal.fire({
type: 'success',
title: "<?php echo $_GET['keterangan']; ?>"
})
</script>
<?php } ?>
 <!-- ALERT FLEKSIBEL YANG MENERIMA STATUS DARI FILE AKSI -->

<!-- PANGGIL FILE HEADER.PHP -->
<?php include("header.php"); ?>
<!-- PANGGIL FILE HEADER.PHP -->

<!-- My Order section starts  -->

<section class="shop" id="shop">

    <h1 class="heading">My Order</h1>
    
    <div class="box-container">
    
        <?php $query_pesanan = mysqli_query($link,"SELECT * FROM pesanan WHERE id_user='$id_user' AND status<>'4' ORDER BY tanggal_pesanan ");
        while ($pesanan = mysqli_fetch_assoc($query_pesanan)) {
        ?>
       
        <div class="box">
            <font style="font-size: 16px; color: purple;">ID Pesanan :</font>
            <h3><?php echo $pesanan['id_order']; ?></h3>
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
                    echo "BARANG DI TERIMA<br>PESANAN SELESAI";
                }
                 ?>
            </div>
             <?php if ($status_pesanan == 3){ ?>
                 <a style="cursor: pointer;" onclick="konfirmasi_penerimaan_pesanan('<?php echo $pesanan['id_order']; ?>');"><button class="btn">Konfirmasi Penerimaan</button></a>  
            <?php } ?>
            

            <a style="cursor: pointer;" href="my_order_detail.php?id_order=<?php echo $pesanan['id_order']; ?>"><button class="btn">Detail Pesanan</button></a>

            <?php if ($status_pesanan == 1){ ?>
                <a style="cursor: pointer;" href="konfirmasi_pembayaran.php?id_order=<?php echo $pesanan['id_order']; ?>"><button class="btn">Cara Membayar</button></a>  

                <a style="cursor: pointer;" onclick="batalkan_pesanan('<?php echo $pesanan['id_order']; ?>');"><button class="btn">Batalkan Pemesanan</button></a>    
            <?php } ?>
            

                   </div>
        <?php } ?>
    
    </div>
    </section>
    
<!-- My Order section ends -->


<!-- PANGGIL FILE FOOTER.PHP -->
<?php include("footer.php"); ?>
<!-- PANGGIL FILE FOOTER.PHP -->


<!-- initializing aos  -->
<script>
    AOS.init({
        delay:400,
        duration:1000
    })


function batalkan_pesanan(id_pesanan){
   Swal.fire({
  title: 'Batalkan Pesanan : '+id_pesanan+' ?',
  text: "",
  type: 'question',
  showCancelButton: true,
  cancelButtonText: 'Tidak',
  confirmButtonText: 'Ya'
}).then((result) => {
  if (result.value) {
location.href="batalkan_pesanan.php?id_order="+id_pesanan;
}
})

}


function konfirmasi_penerimaan_pesanan(id_pesanan){
   Swal.fire({
  title: 'Konfirmasi Penerimaan Pesanan : '+id_pesanan+' ?',
  text: "",
  type: 'question',
  showCancelButton: true,
  cancelButtonText: 'Tidak',
  confirmButtonText: 'Ya'
}).then((result) => {
  if (result.value) {
location.href="konfirmasi_penerimaan_pesanan_aksi.php?id_order="+id_pesanan;
}
})

}


</script>

</body>
</html>