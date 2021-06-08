<?php 
// START MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
require_once ("config.php");
// FINISH MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigiGear Store</title>

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
window.history.replaceState({}, document.title, "/" + "<?php echo $direktori; ?>shop.php");
Swal.fire({
type: 'error',
title: "<?php echo $_GET['keterangan']; ?>"
})
</script>
<?php }else if($_GET['status'] == "sukses"){ ?>
<script>
window.history.replaceState({}, document.title, "/" + "<?php echo $direktori; ?>shop.php");
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

<!-- shop section starts  -->

<section class="shop" id="shop">

    <h1 class="heading"> <span>shop</span> it now </h1>
    
    <div class="box-container">
    
        <?php $query_barang = mysqli_query($link,"SELECT * FROM barang");
        while ($barang = mysqli_fetch_assoc($query_barang)) {
        ?>
        <a href="detail_barang.php?id_barang=<?php echo $barang['id_barang']; ?>">
        <div class="box">
            <img src="asset/gambar_barang/<?php echo $barang['foto_barang']; ?>.png" alt="" width="100%" height="100%">
            <h3><?php echo $barang['nama_barang']; ?></h3>
            <div class="price"><?php echo rupiah($barang['harga']); ?></div>

            <!-- CEK APAKAH READY STOK ? -->

            <!-- JIKA READY STOK -->
            <?php if ($barang['stok'] > 0 ) { ?>
                <a href="add_to_cart_aksi.php?id_barang=<?php echo $barang['id_barang']; ?>"><button class="btn">add to cart</button></a>
            
            <!-- JIKA STOK KOSONG. TAMPILKAN PESAN SOLD OUT -->
            <?php }else{ ?>
                <font style="color:red; font-size: 18px;">SOLD OUT</font>
            <?php } ?>
        </div></a>
        <?php } ?>
    
        

    </div>
    
    </section>
    
<!-- shop section ends -->


<!-- PANGGIL FILE FOOTER.PHP -->
<?php include("footer.php"); ?>
<!-- PANGGIL FILE FOOTER.PHP -->


<!-- initializing aos  -->
<script>
    AOS.init({
        delay:400,
        duration:1000
    })
</script>

</body>
</html>