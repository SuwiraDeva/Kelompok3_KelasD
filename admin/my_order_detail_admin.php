<?php 
// START MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
require_once ("../config.php");
// FINISH MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER

// PANGGIL FILE CEK STATUS LOGIN
include "cek_status_login_admin.php";

// START PENGAMBILAN DATA ORDER DI DATABASE BERDASARKAN ID ORDER
$id_order = mysqli_real_escape_string($link,strip_tags($_GET['id_order']));
$data_order = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM pesanan WHERE id_order='$id_order' "));
// FINISH PENGAMBILAN DATA ORDER DI DATABASE BERDASARKAN ID ORDER
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order Detail - DigiGear Store</title>

    <!-- CSS asset -->
    <link rel="stylesheet" href="../asset/css/sweetalert2.min.css" />
    <link rel="stylesheet" href="../asset/css/aos.css">
    <link rel="preconnect" href="../asset/css/css2.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/style.css">
    <!-- CSS asset -->

    <!-- JAVASCRIPT asset -->
    <script src="../asset/js/aos.js"></script>
    <script src="../asset/js/jquery.min.js"></script>
    <script src="../asset/js/script.js"></script>
    <script src="../asset/js/font-awesome3769096239.js"></script>
    <script src="../asset/js/sweetalert2.min.js"></script>
    <!-- JAVASCRIPT asset -->
    
</head>
<body>
 <!-- ALERT FLEKSIBEL YANG MENERIMA STATUS DARI FILE AKSI -->
<?php if($_GET['status'] == "error"){?>
<script>
window.history.replaceState({}, document.title, "/" + "<?php echo $direktori_admin; ?>my_order_detail_admin.php?id_order=<?php echo $_GET['id_order']; ?>");
Swal.fire({
type: 'error',
title: "<?php echo $_GET['keterangan']; ?>"
})
</script>
<?php }else if($_GET['status'] == "sukses"){ ?>
<script>
window.history.replaceState({}, document.title, "/" + "<?php echo $direktori_admin; ?>my_order_detail_admin.php?id_order=<?php echo $_GET['id_order']; ?>");
Swal.fire({
type: 'success',
title: "<?php echo $_GET['keterangan']; ?>"
})
</script>
<?php } ?>
 <!-- ALERT FLEKSIBEL YANG MENERIMA STATUS DARI FILE AKSI -->

<!-- header section starts  -->
<?php include("header_admin.php"); ?>
<!-- header section ends -->


<!-- cart section starts  -->
<section class="shop" id="shop">

    <h1 class="heading"> My Order Detail </h1>
    
    <div class="box-container">
    
        <?php
        // VARIABEL TOTAL PEMBAYARAN
        $total_bayar = 0;
        $total_berat = 0;
         $query_order = mysqli_query($link,"SELECT * FROM pesanan_barang INNER JOIN barang ON pesanan_barang.id_barang = barang.id_barang WHERE id_order='$id_order' ");
        
        while ($order = mysqli_fetch_assoc($query_order)) {
        $total_bayar = $total_bayar + ($order['jumlah_dipesan']*$order['harga_dipesan']);
        $total_berat = $total_berat + ($order['berat'] * $order['jumlah_dipesan']);
        ?>
        <a href="detail_barang_admin.php?id_barang=<?php echo $order['id_barang']; ?>">
            <div class="box">
            <img src="../asset/gambar_barang/<?php echo $order['foto_barang']; ?>.png" alt="" width="100%" height="100%">
            <h3><?php echo $order['nama_barang']; ?></h3>
            <div style="color: green; font-size: 17px; text-align: center;"><b><?php echo rupiah($order['harga_dipesan']); ?></b></div>
            <div style="color: green; font-size: 17px; text-align: center;">Jumlah Beli : <?php echo $order['jumlah_dipesan']; ?></div><br>
            
            <div style="color: gray; font-size: 17px; text-align: center;"><b>Berat Satuan : <?php echo $order['berat']." KG"; ?></b></div><br>

            <div style="color: gray; font-size: 17px; text-align: center;"><b>Berat Total : <?php echo $order['berat'] * $order['jumlah_dipesan']. " KG"; ?></b></div><br>

            <div style="color: gray; font-size: 17px; text-align: center;">Ongkir : <?php echo rupiah(($order['berat'] * $order['jumlah_dipesan']) * 65000); ?></div><br>

            <div style="color: orange; font-size: 17px; text-align: center;"><b>SubTotal : <?php echo rupiah($order['jumlah_dipesan']*$order['harga_dipesan']); ?></b></div>

            <div style="color: red; font-size: 17px; text-align: center;"><b>Total : <?php echo rupiah( ($order['jumlah_dipesan']*$order['harga_dipesan'] ) + ($order['jumlah_dipesan']*$order['berat'] * 65000 )); ?></b></div>
        </div>
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
    
        <form  method="post" enctype="multipart/form-data" data-aos="fade-right">

            <br><font style="font-size:18px;">Nama Pemesan / Penerima</font><br>
            <input type="text" readonly="true" placeholder="Nama Penerima / Pemesan" name="nama_penerima" class="box" value="<?php echo $data_order['nama_penerima']; ?>"><br>

            <br><font style="font-size:18px;">Nomor HP</font><br>
            <input type="number" readonly="true" placeholder="No. HP" name="no_hp" class="box" value="<?php echo $data_order['no_hp']; ?>"><br>
            <br><font style="font-size:18px;">Alamat Lengkap Pengiriman</font><br>
            <textarea cols="30" readonly="true" rows="10" class="box address" placeholder="Alamat Lengkap Pengiriman" name="alamat"><?php echo $data_order['alamat_lengkap']; ?></textarea><br>

            <br><font style="font-size:18px;">Verifikasi Nomor Rekening / Metode Pembayaran Yang Digunakan Untuk Pembayaran :</font><br>
            <textarea cols="30" readonly="true" rows="10" class="box address" placeholder="Silahkan Masukan Nama Bank, Nama Pemegang Rekening Dan Nomor Rekening Dengan Benar !" name="keterangan_pembayaran"><?php echo $data_order['keterangan_pembayaran']; ?></textarea><br>
            <hr>

            <br><font style="font-size:18px;">Rincian Berat Barang :<br><b>Dikirim Melalui Pos Indonesia</b> </font><br>
            <textarea cols="30" readonly="true" rows="10" class="box address" placeholder=""><?php echo $total_berat.' KG X Rp. 65.000'; ?></textarea>
            

            <br><font style="font-size:18px;">Total Biaya Pengiriman : </font><br>
            <input type="text" readonly="true" placeholder="Total Bayar" name="total_ongkir" class="box" value="<?php echo rupiah($data_order['ongkir']); ?>"><br>

            <br><font style="font-size:18px;">Total Di Transfer : </font><br>
            <input type="text" readonly="true" placeholder="Total Bayar" name="total_bayar_readonly" class="box" value="<?php echo rupiah($total_bayar + ($total_berat * 65000)); ?>"><br>


            <?php
                $status_pesanan = $data_order['status'];
                if ($status_pesanan == 2 || $status_pesanan == 3) { ?>
                 <br><font style="font-size:18px;">Nomor Resi Pengiriman</font><br>
            <input type="text" placeholder="No. Resi Pengiriman" name="no_resi_kurir" class="box" value="<?php echo $data_order['resi_kurir']; ?>"><br>
                <?php } ?>
                  <br><br>

            <?php
              
                if ($status_pesanan == 1) { ?>
                    <a style="cursor: pointer;" class="btn" href="konfirmasi_penerimaan_pembayaran.php?id_order=<?php echo $data_order['id_order']; ?>">Konfirmasi Penerimaan Pembayaran</a>
                <?php }else if ($status_pesanan == 2) { ?>
                    <a style="cursor: pointer;" class="btn" href="konfirmasi_nomor_resi.php?id_order=<?php echo $data_order['id_order']; ?>">Konfirmasi Pengiriman / Kirim Nomor Resi</a>
                <?php }else if ($status_pesanan == 3) { ?>
                    <a style="cursor: pointer;" class="btn" href="konfirmasi_nomor_resi.php?id_order=<?php echo $data_order['id_order']; ?>">Ganti Nomor Resi</a>
                <?php } ?>
                  
            

            
        </form>
    <div class="image" id="preview_bukti_transfer" data-aos="fade-left">
        <input type="hidden" name="nama_file_gambar" id="nama_file_gambar" value="<?php echo $data_order['foto_bukti_transfer']; ?>">
            <font style="position: absolute; color: white; background-color: black; padding: 10px; font-size: 26px; top: 8px; left: 16px;"><b>Bukti Transfer</b></font>
            <img src="../asset/gambar_bukti_transfer/<?php echo $data_order['foto_bukti_transfer']; ?>.png" id="preview_gambar" width="100%" height="100%" alt="sadasd">
        </div>
    </div>
    
    </section>
    
<!-- CHECKOUT -->

<!-- footer section starts  -->
<?php include("../footer.php"); ?>
<!-- footer section ends -->

<!-- initializing aos  -->
<script>
    // START HIDE PREVIEW APABILA TIDAK ADA FOTO / GAMBAR 
if (document.getElementById("nama_file_gambar").value == "") {
    $("#preview_bukti_transfer").hide();
}else{
    $("#preview_bukti_transfer").show();
}
// FINISH HIDE PREVIEW APABILA TIDAK ADA FOTO / GAMBAR 

    AOS.init({
        delay:400,
        duration:1000
    })
</script>

</body>
</html>