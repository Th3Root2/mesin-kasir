<?php
include("../Service/koneksi.php");

$id = $_GET["id"];  

mysqli_query($koneksi,"DELETE FROM barang WHERE id='$id'");

header("Location: data-produk.php");

exit;
?>