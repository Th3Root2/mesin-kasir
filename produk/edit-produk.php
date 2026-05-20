<?php
include "../Service/koneksi.php";

if (!isset($_GET['id'])) {
    header("Location: data-produk.php");
    exit;
}

$id = $_GET['id'];

$query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {

    $deskripsi = $_POST['deskripsi'];
    $nama  = $_POST['nama_barang'];
    $stok  = $_POST['stok_pcs'];
    $isi   = $_POST['isi_per_dus'];
    $ecer  = str_replace('.', '', $_POST['harga_satuan']);
    $dus   = str_replace('.', '', $_POST['harga_dus']);
    $kategori = $_POST['kategori']; // 🔥 TAMBAHAN

    // default pakai gambar lama
    $gambar_final = $data['gambar'];

    // kalau upload gambar baru
    if(isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0){

        $upload_dir = '../Assets-produk/';
        $gambar_file = $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_dir.$gambar_file);

        $gambar_final = $gambar_file;
    }

    mysqli_query($koneksi, "
        UPDATE barang SET
            nama_barang='$nama',
            stok_pcs='$stok',
            isi_per_dus='$isi',
            harga_satuan='$ecer',
            harga_dus='$dus',
            deskripsi='$deskripsi',
            kategori='$kategori', -- 🔥 TAMBAHAN
            gambar='$gambar_final'
        WHERE id='$id'
    ");

    header("Location: data-produk.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Barang</title>
<link href="../admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="../css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

<div id="wrapper">

    <?php include "../admin/sidebar.php"; ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            <?php include "../admin/topbar.php"; ?>

            <div class="container-fluid">

                <h1 class="h3 mb-4 text-gray-800">Edit Barang</h1>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Form Edit Produk
                        </h6>
                    </div>

                    <div class="card-body">

                        <form method="POST" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control"
                                value="<?= $data['nama_barang']; ?>" required>
                            </div>

                            <!-- 🔥 KATEGORI -->
                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="kategori" class="form-control" required>
                                    <option value="Elektronik" <?= $data['kategori']=='Elektronik'?'selected':''; ?>>Elektronik</option>
                                    <option value="Aksesoris" <?= $data['kategori']=='Aksesoris'?'selected':''; ?>>Aksesoris</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Stok (pcs)</label>
                                <input type="number" name="stok_pcs" class="form-control"
                                value="<?= $data['stok_pcs']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Isi per Dus</label>
                                <input type="number" name="isi_per_dus" class="form-control"
                                value="<?= $data['isi_per_dus']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Harga Satuan</label>
                                <input type="text" name="harga_satuan" class="form-control"
                                value="<?= number_format($data['harga_satuan'], 0, ',', '.'); ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Harga Dus</label>
                                <input type="text" name="harga_dus" class="form-control"
                                value="<?= number_format($data['harga_dus'], 0, ',', '.'); ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="5" required><?= $data['deskripsi']; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Upload Gambar</label><br>
                                <img src="../Assets-produk/<?= $data['gambar'] ?>" width="100" class="mb-2"><br>
                                <input type="file" name="gambar" accept="image/*">
                            </div>

                            <button type="submit" name="update" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update
                            </button>

                            <a href="data-produk.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>

                        </form>

                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

</body>
</html>