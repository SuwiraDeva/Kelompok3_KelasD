<?php 
// START MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER
require_once ("../config.php");
// FINISH MEMANGGIL FILE CONFIG UNTUK MENGHUBUNGKAN KE DATABASE SERVER

// START PENGAMBILAN DATA BARANG DI DATABASE BERDASARKAN ID BARANG
$id_barang = mysqli_real_escape_string($link,strip_tags($_GET['id_barang']));
$data_barang = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM barang WHERE id_barang='$id_barang' "));
// FINISH PENGAMBILAN DATA BARANG DI DATABASE BERDASARKAN ID BARANG
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang - DigiGear Store Admin</title>

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
<?php include("header_admin.php"); ?>
<!-- header section ends -->

<!-- edit Barang section starts  -->
<section class="order" id="order">

    <h1 class="heading"><span>Detail Barang</span> </h1>
    
    <div class="row">
    
        <form action="edit_jumlah_beli_aksi.php" method="post" enctype="multipart/form-data" >

            <input type="hidden" name="id_barang" value="<?php echo $id_barang; ?>">

            <br><font style="font-size:18px;">Nama Barang</font><br>
            <input type="text" readonly="true" placeholder="Nama Barang" name="nama_barang" class="box" value="<?php echo $data_barang['nama_barang']; ?>"><br>

            <br><font style="font-size:18px;">Harga Barang</font><br>
            <input type="text" readonly="true" placeholder="Harga Barang" name="harga_barang" class="box" value="<?php echo rupiah($data_barang['harga']); ?>"><br>

            <br><font style="font-size:18px;">Stok Barang Ready ( Unit )</font><br>
            <input type="number" readonly="true" placeholder="Stok Barang" name="stok_barang" class="box" value="<?php echo $data_barang['stok']; ?>"><br>

            <br><font style="font-size:18px;">Deskripsi</font><br>
            <textarea cols="30" readonly="true" rows="10" class="box address" placeholder="Deskripsi" name="deskripsi"><?php echo $data_barang['keterangan']; ?></textarea><br>
        </form>
    
        <div class="image" data-aos="fade-left"><font style="position: absolute; color: white; background-color: black; padding: 10px; font-size: 26px; top: 8px; left: 16px;"><b>Foto Barang</b></font>
            <img src="../asset/gambar_barang/<?php echo $data_barang['foto_barang']; ?>.png" id="preview_gambar" width="100%" height="100%" alt="">
        </div>
    
    </div>
    
    </section>
    
<!-- edit Barang section ends -->

<!-- footer section starts  -->
<?php include("../footer.php"); ?>
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