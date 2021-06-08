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
    <title>Daftar Barang - DigiGear Store Admin</title>

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
window.history.replaceState({}, document.title, "/" + "<?php echo $direktori_admin; ?>daftar_barang.php");
Swal.fire({
type: 'error',
title: "<?php echo $_GET['keterangan']; ?>"
})
</script>
<?php }else if($_GET['status'] == "sukses"){ ?>
<script>
window.history.replaceState({}, document.title, "/" + "<?php echo $direktori_admin; ?>daftar_barang.php");
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

    <h1 class="heading"> <span>Daftar Barang</span> </h1>
    
    <div class="box-container">
    
        <?php $query_barang = mysqli_query($link,"SELECT * FROM barang");
        while ($barang = mysqli_fetch_assoc($query_barang)) {
        ?>
        <a href="detail_barang_admin.php?id_barang=<?php echo $barang['id_barang']; ?>">
            <div class="box" >
            <img src="../asset/gambar_barang/<?php echo $barang['foto_barang']; ?>.png" alt="" width="100%" height="100%">
            <h3><?php echo $barang['nama_barang']; ?></h3>
            <div class="price"><?php echo rupiah($barang['harga']); ?></div>
            <a href="edit_barang.php?id_barang=<?php echo $barang['id_barang']; ?>"><button class="btn">Edit</button></a>
            <a style="cursor: pointer;" onclick="hapus_data_barang('<?php echo $barang['id_barang']; ?>' , '<?php echo $barang['nama_barang']; ?>' );"><button class="btn">Hapus</button></a>
        </div>
        </a>
        <?php } ?>
          

    </div>
    <div style="text-align: center;" data-aos="fade-right">
        <a href="tambah_barang.php"><button class="btn">Tambah Daftar Barang Baru</button></a>
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