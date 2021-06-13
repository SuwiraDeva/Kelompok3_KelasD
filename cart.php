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
    <title>Cart - DigiGear Store</title>

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
window.history.replaceState({}, document.title, "/" + "<?php echo $direktori; ?>cart.php");
Swal.fire({
type: 'error',
title: "<?php echo $_GET['keterangan']; ?>"
})
</script>
<?php }else if($_GET['status'] == "sukses"){ ?>
<script>
window.history.replaceState({}, document.title, "/" + "<?php echo $direktori; ?>cart.php");
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


<!-- cart section starts  -->

<section class="shop" id="shop">

    <h1 class="heading"> <span>Cart</span> </h1>
    
    <div class="box-container">
    
        <?php $query_cart = mysqli_query($link,"SELECT * FROM cart INNER JOIN barang ON cart.id_barang = barang.id_barang WHERE id_user='$id_user' ");
        echo mysqli_error($link);
        while ($cart = mysqli_fetch_assoc($query_cart)) {
             $total_bayar = $total_bayar + ($cart['jumlah']*$cart['harga']);
        ?>
        <a href="detail_barang.php?id_barang=<?php echo $cart['id_barang']; ?>">
            <div class="box">
            <img src="asset/gambar_barang/<?php echo $cart['foto_barang']; ?>.png" alt="" width="100%" height="100%">
            <h3><?php echo $cart['nama_barang']; ?></h3>
            <div class="price"><?php echo rupiah($cart['harga']); ?></div>
            <div style="color: green; font-size: 17px; text-align: center;">Jumlah Beli : <?php echo $cart['jumlah']; ?></div>
            <div style="color: red; font-size: 24px; text-align: center;">SubTotal : <?php echo rupiah($cart['jumlah']*$cart['harga']); ?></div>
            <!-- CEK APAKAH READY STOK ? -->

            <!-- JIKA READY STOK -->
            <?php if ($cart['stok'] > 0 ) { ?>
                <a href="edit_jumlah_beli.php?id_barang=<?php echo $cart['id_barang']; ?>"><button class="btn">Edit Jumlah Beli</button></a>
            
            <!-- JIKA STOK KOSONG. TAMPILKAN PESAN SOLD OUT -->
            <?php }else{ ?>
                <font style="color:red; font-size: 18px;">SOLD OUT</font>
            <?php } ?>

            <a style="cursor: pointer;" onclick="hapus_barang_cart('<?php echo $cart['id_barang']; ?>' , '<?php echo $cart['nama_barang']; ?>' );"><button class="btn">Hapus</button></a>
        </div>
        </a>
        <?php } ?>
          

    </div>
    

    <!-- CHECK APAKAH ADA BARANG DI DALAM CART. JIKA ADA. TAMPILKAN TOMBOL CHECKOUT -->
    <?php $cek_cart = mysqli_fetch_assoc(mysqli_query($link, "SELECT COUNT(*) as jumlah_barang_di_cart FROM cart WHERE id_user='$_SESSION[user_login]' "));
    if ($cek_cart['jumlah_barang_di_cart'] != 0) {
     ?>
     <div style="color: blue; font-size: 30px; text-align: center;">Total : <?php echo rupiah($total_bayar); ?></div>
    <div style="text-align: center;" >
        <a href="checkout.php"><button class="btn">Checkout</button></a>
    </div>
    <?php }?>
    <!-- CHECK APAKAH ADA BARANG DI DALAM CART. JIKA ADA. TAMPILKAN TOMBOL CHECKOUT -->
    </section>
    
<!-- cart section ends -->


<!-- PANGGIL FILE FOOTER.PHP -->
<?php include("footer.php"); ?>
<!-- PANGGIL FILE FOOTER.PHP -->


<!-- initializing aos  -->
<script>
    AOS.init({
        delay:400,
        duration:1000
    })


function hapus_barang_cart(id_barang, nama_barang){
   Swal.fire({
  title: 'Hapus Barang : '+nama_barang+' Dari Cart ?',
  text: "",
  type: 'question',
  showCancelButton: true,
  cancelButtonText: 'Tidak',
  confirmButtonText: 'Ya'
}).then((result) => {
  if (result.value) {
location.href="hapus_barang_cart_aksi.php?id_barang="+id_barang;
}
})

}

</script>

</body>
</html>