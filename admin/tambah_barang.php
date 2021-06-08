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
    <title>Tambah Barang - DigiGear Store Admin</title>

    <!-- CSS ../asset -->
    <link rel="stylesheet" href="../asset/css/sweetalert2.min.css" />
    <link rel="stylesheet" href="../asset/css/aos.css">
    <link rel="preconnect" href="../asset/css/css2.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/style.css">
    <!-- CSS ../asset -->

    <!-- JAVASCRIPT ../asset -->
    <script src="../asset/js/aos.js"></script>
    <script src="../asset/js/jquery.min.js"></script>
    <script src="../asset/js/script.js"></script>
    <script src="../asset/js/font-awesome3769096239.js"></script>
    <script src="../asset/js/sweetalert2.min.js"></script>
    <!-- JAVASCRIPT ../asset -->
    
</head>
<body>
 <!-- ALERT FLEKSIBEL YANG MENERIMA STATUS DARI FILE AKSI -->
<?php if($_GET['status'] == "error"){?>
<script>
window.history.replaceState({}, document.title, "/" + "<?php echo $direktori_admin; ?>tambah_barang.php");
Swal.fire({
type: 'error',
title: "<?php echo $_GET['keterangan']; ?>"
})
</script>
<?php }else if($_GET['status'] == "sukses"){ ?>
<script>
window.history.replaceState({}, document.title, "/" + "<?php echo $direktori_admin; ?>tambah_barang.php");
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

<!-- Tambah Barang section starts  -->
<section class="order" id="order">

    <h1 class="heading"><span>Tambah Barang</span> </h1>
    
    <div class="row">
    
        <form action="tambah_barang_aksi.php" method="post" enctype="multipart/form-data" data-aos="fade-right">
            <br><font style="font-size:18px;">Nama Barang</font><br><br>
            <input type="text" placeholder="Nama Barang" name="nama_barang" class="box"><br>

            <br><font style="font-size:18px;">Harga Barang ( Rp. )</font><br><br>
            <input type="number" placeholder="Harga Barang" name="harga_barang" class="box"><br>

            <br><font style="font-size:18px;">Stok Barang ( Unit )</font><br><br>
            <input type="number" placeholder="Stok Barang" name="stok_barang" class="box"><br>

            <br><font style="font-size:18px;">Berat Barang ( KG )</font><br><br>
            <input type="number" placeholder="Berat Barang" name="berat" class="box"><br>

            <br><font style="font-size:18px;">Deskripsi</font><br><br>
            <textarea cols="30" rows="10" class="box address" placeholder="Deskripsi" name="deskripsi"></textarea><br>

            <font style="font-size: 18px;">Silahkan Pilih Foto/Gambar Barang :</font><br>
  <input type="file" name="upload_gambar" id="upload_gambar" class="btn">
  <hr>
            <input type="submit" value="Simpan Data Barang" class="btn">
        </form>
    
        <div class="image" data-aos="fade-left">
            <img src="" id="preview_gambar" style="display:none;" width="100%" height="100%" alt="">
        </div>
    
    </div>
    
    </section>
    
<!-- Tambah Barang section ends -->

<!-- footer section starts  -->
<?php include("../footer.php"); ?>
<!-- footer section ends -->

<!-- initializing aos  -->
<script>
    AOS.init({
        delay:400,
        duration:1000
    })

// START FUNGSI DETEKSI APABILA ADA GAMBAR DIPILIH UNTUK PREVIEW
upload_gambar.onchange = evt => {
  const [file] = upload_gambar.files
  if (file) {
    $("#preview_gambar").show();
    preview_gambar.src = URL.createObjectURL(file)
  }else{
    $("#preview_gambar").hide();
    preview_gambar.src = "";
  }
}
// FINISH FUNGSI DETEKSI APABILA ADA GAMBAR DIPILIH UNTUK PREVIEW
</script>

</body>
</html>