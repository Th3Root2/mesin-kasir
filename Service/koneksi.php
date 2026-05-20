<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "mesinkasir";

$koneksi = mysqli_connect($hostname, $username, $password, $database_name);


// if($koneksi == true) {
    // echo"Database  terhubung";
// } else {
    // echo "Database gagal terhubung";
// }

if (!$koneksi) {
    die("Koneksi Gagal:" . mysqli_connect_error());
}
?>  