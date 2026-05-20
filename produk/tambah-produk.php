<?php
session_start();
include "../Service/koneksi.php";

// wajib login
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

// cek role admin
if ($_SESSION['role'] != 'admin') {
    echo "Akses ditolak!";
    exit;
}

if (isset($_POST['simpan'])) {

    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $stok   = (int) $_POST['stok_pcs'];
    $isi    = (int) $_POST['isi_per_dus'];
    $kategori = $_POST['kategori']; // 🔥 TAMBAHAN
    $deskripsi = $_POST['deskripsi'];

    $gambar_nama = '';

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $upload_dir = '../Assets-produk/';
        $gambar_file = $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_dir . $gambar_file);
        $gambar_nama = $gambar_file;
    }

    $harga_ecer = str_replace('.', '', $_POST['harga_satuan']);
    $harga_dus  = str_replace('.', '', $_POST['harga_dus']);

    mysqli_query($koneksi, "
        INSERT INTO barang
        (nama_barang, stok_pcs, isi_per_dus, harga_satuan, harga_dus, kategori, gambar, deskripsi)
        VALUES
        ('$nama', '$stok', '$isi', '$harga_ecer', '$harga_dus', '$kategori', '$gambar_nama', '$deskripsi')
    ");

    header("Location: data-produk.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Tambah Produk</title>

<link href="../admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="../css/sb-admin-2.min.css" rel="stylesheet">

<style>
.preview-box {
    border: 2px dashed #d1d3e2;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
}
.preview-box:hover {
    background: #f8f9fc;
}
</style>
</head>

<body id="page-top">

<div id="wrapper">

<?php include "../admin/sidebar.php"; ?>

<div id="content-wrapper" class="d-flex flex-column">
<div id="content">

<?php include "../admin/topbar.php"; ?>

<div class="container-fluid">

<h1 class="h3 mb-4 text-gray-800">Tambah Produk</h1>

<div class="card shadow mb-4">
<div class="card-body">

<form method="POST" enctype="multipart/form-data">

<div class="row">

<!-- LEFT -->
<div class="col-md-7">

<div class="form-group">
<label>Nama Produk</label>
<input type="text" name="nama_barang" class="form-control" required>
</div>

<!-- 🔥 KATEGORI -->
<div class="form-group">
<label>Kategori</label>
<select name="kategori" class="form-control" required>
    <option value="">-- Pilih Kategori --</option>
    <option value="Elektronik">Elektronik</option>
    <option value="Aksesoris">Aksesoris</option>
</select>
</div>

<div class="row">
<div class="col-md-6">
<div class="form-group">
<label>Stok (pcs)</label>
<input type="number" name="stok_pcs" class="form-control" required>
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label>Isi per Dus</label>
<input type="number" name="isi_per_dus" class="form-control" required>
</div>
</div>
</div>

<div class="row">
<div class="col-md-6">
<div class="form-group">
<label>Harga Satuan</label>
<input type="text" name="harga_satuan" class="form-control" placeholder="12.000" required>
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label>Harga Dus</label>
<input type="text" name="harga_dus" class="form-control" placeholder="120.000" required>
</div>
</div>
</div>

<div class="form-group">
<label>Deskripsi</label>
<textarea name="deskripsi" class="form-control" rows="4"></textarea>
</div>

</div>

<!-- RIGHT -->
<div class="col-md-5">

<label>Upload Gambar</label>

<div class="preview-box" onclick="document.getElementById('gambar').click()">
<input type="file" id="gambar" name="gambar" hidden>
<div id="previewText">Klik untuk upload gambar</div>
<div id="previewImage"></div>
</div>

</div>

</div>

<hr>

<div class="d-flex justify-content-between">
<a href="data-produk.php" class="btn btn-secondary">
<i class="fas fa-arrow-left"></i> Kembali
</a>

<button type="submit" name="simpan" class="btn btn-primary">
<i class="fas fa-save"></i> Simpan
</button>
</div>

</form>

</div>
</div>

</div>

</div>
</div>

</div>

<script src="../admin/vendor/jquery/jquery.min.js"></script>
<script src="../admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../admin/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../admin/js/sb-admin-2.min.js"></script>

<script>
const input = document.getElementById("gambar");
const previewImage = document.getElementById("previewImage");
const previewText = document.getElementById("previewText");

input.addEventListener("change", function() {
    const file = this.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewText.style.display = "none";
            previewImage.innerHTML = `<img src="${e.target.result}" style="width:100%; border-radius:10px;">`;
        }

        reader.readAsDataURL(file);
    }
});
</script>

</body>
</html>