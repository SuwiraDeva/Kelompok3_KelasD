<?php 
// START MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
require_once ("config.php");
// FINISH MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER

// PANGGIL FILE CEK STATUS LOGIN
include "cek_status_login.php";

// START PENGAMBILAN DATA ORDER DI DATABASE BERDASARKAN ID ORDER
$id_order = mysqli_real_escape_string($link,strip_tags($_GET['id_order']));
$data_order = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM pesanan WHERE id_order='$id_order' "));
// FINISH PENGAMBILAN DATA ORDER DI DATABASE BERDASARKAN ID ORDER

// START PENGAMBILAN DATA REKENING
$rekening = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM rekening "));
// FINISH PENGAMBILAN DATA REKENING
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi & Detail Pembayaran - DigiGear Store</title>

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
window.history.replaceState({}, document.title, "/" + "<?php echo $direktori; ?>detail_barang.php?id_barang=<?php echo $id_barang; ?>");
Swal.fire({
type: 'error',
title: "<?php echo $_GET['keterangan']; ?>"
})
</script>
<?php }else if($_GET['status'] == "sukses"){ ?>
<script>
window.history.replaceState({}, document.title, "/" + "<?php echo $direktori; ?>detail_barang.php?id_barang=<?php echo $id_barang; ?>");
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

<!-- edit Barang section starts  -->
<section class="order" id="order">

    <h1 class="heading"><span>Konfirmasi Pembayaran</span> </h1>
    
    <div class="row">
    
        <form action="konfirmasi_pembayaran_aksi.php" method="post" enctype="multipart/form-data" data-aos="fade-right">

            <input type="hidden" name="id_order" value="<?php echo $id_order; ?>">
             
            <br><font style="font-size:18px; color: gray;">ID Order</font><br>
             <br><font style="font-size:24px; color: red;"><?php echo $data_order['id_order']; ?></font><br><hr><br>

             <br><font style="font-size:18px; color: gray;">Tanggal Order</font><br>
             <br><font style="font-size:24px; color: orange;"><?php echo $data_order['tanggal_pesanan']; ?></font><br><hr><br>

             <br><font style="font-size:18px; color: blue;">Total Tagihan</font><br>
             <br><font style="font-size:24px; color: gray;"><?php echo rupiah($data_order['total_bayar'] + $data_order['ongkir']); ?></font><br><hr><br>

            <br><font style="font-size:18px;">Silahkan Melakukan Pembayaran Pada Nomor Rekening Berikut :</font><br>
            <br><font style="font-size:18px; color: green;"><?php echo str_replace("\r\n", "<br>", $rekening['detail_rekening']); ?></font><br><hr><br>

            <br><font style="font-size:18px;">Verifikasi Nomor Rekening / Metode Pembayaran Yang Digunakan Untuk Pembayaran :</font><br>
            <textarea cols="30" rows="10" class="box address" placeholder="Silahkan Masukan Nama Bank, Nama Pemegang Rekening Dan Nomor Rekening Dengan Benar !" name="keterangan_pembayaran"><?php echo $data_order['keterangan_pembayaran']; ?></textarea><br>
            <hr>

              <input type="hidden" name="nama_file_gambar" id="nama_file_gambar" value="<?php echo $data_order['foto_bukti_transfer']; ?>">

             <font style="font-size: 18px;">Silahkan Pilih Foto/Gambar Bukti Transfer :</font><br>
                <input type="file" name="upload_gambar" id="upload_gambar" class="btn"><br>

            <input type="submit" value="Konfirmasi Pembayaran" class="btn">

        </form>

        <div class="image" id="preview_bukti_transfer" data-aos="fade-left"><font style="position: absolute; color: white; background-color: black; padding: 10px; font-size: 26px; top: 8px; left: 16px;"><b>Bukti Transfer</b></font>
            <img src="asset/gambar_bukti_transfer/<?php echo $data_order['foto_bukti_transfer']; ?>.png" id="preview_gambar" width="100%" height="100%" alt="">
        </div>
    </div>
    
    </section>
    
<!-- edit Barang section ends -->

<!-- footer section starts  -->
<?php include("footer.php"); ?>
<!-- footer section ends -->

<!-- initializing aos  -->
<script>
    AOS.init({
        delay:400,
        duration:1000
    })

// START HIDE PREVIEW APABILA TIDAK ADA FOTO / GAMBAR 
if (document.getElementById("nama_file_gambar").value == "") {
    $("#preview_bukti_transfer").hide();
}else{
    $("#preview_bukti_transfer").show();
}
// FINISH HIDE PREVIEW APABILA TIDAK ADA FOTO / GAMBAR 

    // START FUNGSI DETEKSI APABILA ADA GAMBAR DIPILIH UNTUK PREVIEW
upload_gambar.onchange = evt => {
  const [file] = upload_gambar.files
  if (file) {
    document.getElementById("nama_file_gambar").value = URL.createObjectURL(file);
    $("#preview_bukti_transfer").show();
    preview_gambar.src = URL.createObjectURL(file);
  }else{
    document.getElementById("nama_file_gambar").value = "";
    $("#preview_bukti_transfer").hide();
    preview_gambar.src = "";
  }
}
// FINISH FUNGSI DETEKSI APABILA ADA GAMBAR DIPILIH UNTUK PREVIEW
</script>

</body>
</html>