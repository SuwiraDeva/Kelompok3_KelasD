<?php 
// START CEK DATA PADA DATABASE
$cek_user = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM user WHERE id_user='$_SESSION[user_login]' "));
$query_cek_cart = mysqli_query($link, "SELECT * FROM cart WHERE id_user='$_SESSION[user_login]' ");
$jumlah_barang_di_cart = 0;
while($cek_jumlah_cart = mysqli_fetch_assoc($query_cek_cart)){
$jumlah_barang_di_cart = $jumlah_barang_di_cart + $cek_jumlah_cart['jumlah']; 
}
$cek_order = mysqli_fetch_assoc(mysqli_query($link, "SELECT COUNT(*) as cek_jumlah_order FROM pesanan WHERE id_user='$_SESSION[user_login]' AND status<>'4'  "));
// START CEK DATA PADA DATABASE
?>
<header>
    <a href="index.php" class="logo"><img src="asset/img/logo.jpeg" alt=""></a>   
    <div id="menu-bar" class="fas fa-mouse"></div>
    
    <nav class="navbar">
        <ul>
            <?php if ($_SESSION['user_login'] == "") { ?>
            <li><a class="active" href="login.php"><b>Sign In</b></a></li>
            <li><a class="active" href="register.php">Sign Up</a></li>
            <li><a class="active" href="aboutus.php">About Us</a></li>
            <?php }else{ ?>
            <li><a href="shop.php">Shop</a></li>
            <li><a href="cart.php">Cart <b>(<?php echo $jumlah_barang_di_cart; ?>)</b></a></li>
            <li><a href="my_order.php">My Order <b>(<?php echo $cek_order['cek_jumlah_order']; ?>)</b></a></li>
            <li><a class="active" href="aboutus.php">About Us</a></li>
            <li><a><b>Hai, <?php echo $cek_user['nama']; ?></b></a></li>
            <li><a href="logout.php">Logout</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>