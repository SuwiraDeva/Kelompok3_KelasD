<?php 
// START MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
require_once ("config.php");
// FINISH MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER

// PANGGIL FILE CEK STATUS LOGIN
include "cek_status_login.php";

$query_cek_sold_out = mysqli_fetch_assoc(mysqli_query($link, "SELECT COUNT(*) as jumlah_barang_sold_out FROM cart INNER JOIN barang ON cart.id_barang = barang.id_barang WHERE id_user='$id_user' AND stok<'1' "));
if ($query_cek_sold_out['jumlah_barang_sold_out'] != 0) {
    header("location:cart.php?status=error&keterangan=ADA BARANG YANG SOLD OUT, SILAHKAN HAPUS DARI CART ANDA !");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - DigiGear Store</title>

    <!-- CSS asset -->
    <link rel="stylesheet" href="asset/css/sweetalert2.min.css" />
    <link rel="stylesheet" href="asset/css/aos.css">
    <link rel="preconnect" href="asset/css/css2.css" rel="stylesheet">
    <link rel="stylesheet" href="asset/css/style.css">
    <!-- CSS asset -->

    <!-- JAVASCRIPT asset -->
    <script src="asset/js/aos.js"></script>
    <script src="asset/js/jquery.min.js"></script>
    <script src="asset/js/script.js"></script>
    <script src="asset/js/font-awesome3769096239.js"></script>
    <script src="asset/js/sweetalert2.min.js"></script>
    <!-- JAVASCRIPT asset -->
    
</head>
<body>
 <!-- ALERT FLEKSIBEL YANG MENERIMA STATUS DARI FILE AKSI -->
<?php if($_GET['status'] == "error"){?>
<script>
window.history.replaceState({}, document.title, "/" + "<?php echo $direktori; ?>checkout.php");
Swal.fire({
type: 'error',
title: "<?php echo $_GET['keterangan']; ?>"
})
</script>
<?php }else if($_GET['status'] == "sukses"){ ?>
<script>
window.history.replaceState({}, document.title, "/" + "<?php echo $direktori; ?>checkout.php");
Swal.fire({
type: 'success',
title: "<?php echo $_GET['keterangan']; ?>"
})
</script>
<?php } ?>
 <!-- ALERT FLEKSIBEL YANG MENERIMA STATUS DARI FILE AKSI -->

<!-- header section starts  -->
<?php include("header.php"); ?>
<!-- header section ends -->


<!-- cart section starts  -->
<section class="shop" id="shop">

    <h1 class="heading"> <span>Barang Yang Dibeli</span> </h1>
    
    <div class="box-container">
    
        <?php
        // VARIABEL TOTAL PEMBAYARAN
        $total_bayar = 0;
        $total_berat = 0;
         $query_cart = mysqli_query($link,"SELECT * FROM cart INNER JOIN barang ON cart.id_barang = barang.id_barang WHERE id_user='$id_user' ");
        echo mysqli_error($link);
        while ($cart = mysqli_fetch_assoc($query_cart)) {
        $total_bayar = $total_bayar + ($cart['jumlah']*$cart['harga']);
        $total_berat = $total_berat + ($cart['berat'] * $cart['jumlah']);
        ?>
        <a href="detail_barang.php?id_barang=<?php echo $cart['id_barang']; ?>">
            <div class="box"">
            <img src="asset/gambar_barang/<?php echo $cart['foto_barang']; ?>.png" alt="" width="100%" height="100%">
            <h3><?php echo $cart['nama_barang']; ?></h3>
            <div style="color: green; font-size: 17px; text-align: center;"><b><?php echo rupiah($cart['harga']); ?></b></div>
            <div style="color: green; font-size: 17px; text-align: center;">Jumlah Beli : <?php echo $cart['jumlah']; ?></div><br>
            
            <div style="color: gray; font-size: 17px; text-align: center;"><b>Berat Satuan : <?php echo $cart['berat']." KG"; ?></b></div><br>

            <div style="color: gray; font-size: 17px; text-align: center;"><b>Berat Total : <?php echo $cart['berat'] * $cart['jumlah']. " KG"; ?></b></div><br>


            <div style="color: gray; font-size: 17px; text-align: center;">Ongkir : <?php echo rupiah(($cart['berat'] * $cart['jumlah']) * 65000); ?></div><br>

            <div style="color: orange; font-size: 17px; text-align: center;"><b>SubTotal : <?php echo rupiah($cart['jumlah']*$cart['harga']); ?></b></div>
        </div>
        <div style="color: red; font-size: 17px; text-align: center;"><b>Total : <?php echo rupiah( ($cart['jumlah']*$cart['harga'] ) + ($cart['jumlah']*$cart['berat'] * 65000 )); ?></b></div>
        </a>
        <?php } ?>
    </div>

    <div style="text-align: center;">
        <a href="#keterangan_pemesanan"><button class="btn">Lanjut Ke Keterangan Pemesanan</button></a>
    </div>
    </section>
<!-- cart section ends -->


<!-- CHECKOUT  -->
<section class="order" id="keterangan_pemesanan">

    <h1 class="heading"><span>Keterangan Pemesanan</span> </h1>
    
    <div class="row">
    
        <form action="checkout_aksi.php" method="post" enctype="multipart/form-data">

            <br><font style="font-size:18px;">Nama Pemesan / Penerima</font><br>
            <input type="text" placeholder="Nama Penerima / Pemesan" name="nama_penerima" class="box" value="<?php echo $cek_user['nama']; ?>"><br>

            <br><font style="font-size:18px;">Nomor HP</font><br>
            <input type="number" placeholder="No. HP" name="no_hp" class="box" value=""><br>
            <br><font style="font-size:18px;">Alamat Lengkap Pengiriman</font><br>
            <textarea cols="30" rows="10" class="box address" placeholder="Alamat Lengkap Pengiriman" name="alamat"></textarea><br>

            <br><font style="font-size:18px;">Rincian Berat Barang :<br><b>Dikirim Melalui Pos Indonesia</b> </font><br>
            <textarea cols="30" readonly="true" rows="10" class="box address" placeholder=""><?php echo $total_berat.' KG X Rp. 65.000'; ?></textarea>
            

            <br><font style="font-size:18px;">Total Biaya Pengiriman : </font><br>
            <input type="text" readonly="true" placeholder="Total Bayar" name="total_ongkir" class="box" value="<?php echo rupiah($total_berat * 65000); ?>"><br>

            <br><font style="font-size:18px;">Total Di Transfer : </font><br>
            <input type="text" readonly="true" placeholder="Total Bayar" name="total_bayar_readonly" class="box" value="<?php echo rupiah($total_bayar + ($total_berat * 65000)); ?>"><br>

            <input type="submit" value="Checkout Pesanan" class="btn">
        </form>
    
    </div>
    
    </section>
    
<!-- CHECKOUT -->

<!-- footer section starts  -->
<?php include("footer.php"); ?>
<!-- footer section ends -->

<!-- initializing aos  -->
<script>
    AOS.init({
        delay:400,
        duration:1000
    })
</script>

</body>
</html>