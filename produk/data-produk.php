<?php
include "../Service/koneksi.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("Location: /mesinkasir/login.php");
    exit;
}


/* =========================
   FILTER KATEGORI
========================= */
$filter = $_GET['kategori'] ?? '';

if ($filter != '') {
    $query = mysqli_query($koneksi, "SELECT * FROM barang WHERE kategori='$filter'");
} else {
    $query = mysqli_query($koneksi, "SELECT * FROM barang");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Data Produk</title>

    <!-- SB ADMIN -->
    <link href="../admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../admin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        td.desc {
            max-width: 220px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        td.desc:hover {
            white-space: normal;
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

                <!-- Heading -->
                <div class="d-flex justify-content-between mb-4">
                    <h1 class="h3 text-gray-800">Data Produk</h1>

                    <div>
                        <a href="../admin/index.php" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Dashboard
                        </a>

                        <a href="tambah-produk.php" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>

                <!-- FILTER -->
                <form method="GET" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="kategori" class="form-control" onchange="this.form.submit()">
                                <option value="">-- Semua Kategori --</option>
                                <option value="Elektronik" <?= $filter=='Elektronik'?'selected':''; ?>>Elektronik</option>
                                <option value="Aksesoris" <?= $filter=='Aksesoris'?'selected':''; ?>>Aksesoris</option>
                            </select>
                        </div>
                    </div>
                </form>

                <!-- CARD -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">List Produk</h6>
                        <small>Total: <?= mysqli_num_rows($query); ?></small>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-bordered" id="dataTable">

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Produk</th>
                                        <th>Kategori</th> <!-- TAMBAHAN -->
                                        <th>Stok</th>
                                        <th>Isi/Dus</th>
                                        <th>Harga</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($data = mysqli_fetch_assoc($query)) {
                                    ?>
                                    <tr>

                                        <td><?= $no++; ?></td>

                                        <td>
                                            <strong><?= $data['nama_barang']; ?></strong><br>
                                            <small class="text-muted">
                                                Per dus: <?= $data['isi_per_dus']; ?>
                                            </small>
                                        </td>

                                        <!-- KATEGORI BADGE -->
                                        <td>
                                            <span class="badge 
                                                <?= $data['kategori']=='Elektronik' ? 'badge-primary' : 'badge-success'; ?>">
                                                <?= $data['kategori']; ?>
                                            </span>
                                        </td>

                                        <td>
                                            <span class="badge <?= $data['stok_pcs'] < 10 ? 'badge-danger' : 'badge-info'; ?>">
                                                <?= $data['stok_pcs']; ?> pcs
                                            </span>
                                        </td>

                                        <td><?= $data['isi_per_dus']; ?></td>

                                        <td>
                                            Rp<?= number_format($data['harga_satuan'], 0, ',', '.'); ?><br>
                                            <small class="text-muted">
                                                Dus: Rp<?= number_format($data['harga_dus'], 0, ',', '.'); ?>
                                            </small>
                                        </td>

                                        <td class="desc"><?= $data['deskripsi']; ?></td>

                                        <td>
                                            <a href="edit-produk.php?id=<?= $data['id']; ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <a href="hapus-produk.php?id=<?= $data['id']; ?>"
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Yakin hapus?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>

                                    </tr>
                                    <?php } ?>
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

<!-- JS -->
<script src="../admin/vendor/jquery/jquery.min.js"></script>
<script src="../admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../admin/vendor/jquery-easing/jquery.easing.min.js"></script>

<script src="../admin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../admin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script src="../admin/js/sb-admin-2.min.js"></script>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable();
});
</script>

</body>
</html>