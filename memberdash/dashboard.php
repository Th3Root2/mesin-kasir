<?php
session_start();
// include __DIR__ . "/../Service/koneksi.php";
include "../Service/koneksi.php";

// ambil kategori unik
$kategori_query = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM barang");

$kategori_list = [];
while ($k = mysqli_fetch_assoc($kategori_query)) {
    $kategori_list[] = $k['kategori'];
}

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['role'] != 'user') {
    header("Location: ../admin/index.php");
    exit;
}



// ambil produk
$produk_query = mysqli_query($koneksi, "SELECT * FROM barang");

$produk = [];
while ($row = mysqli_fetch_assoc($produk_query)) {
    $produk[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Member Dashboard</title>

<link href="../css/sb-admin-2.min.css" rel="stylesheet">
<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">

<style>
.clickable { cursor:pointer; transition:0.2s; }
.clickable:hover { transform: translateY(-4px); }
.card { border-radius: 12px; }
</style>
</head>

<body id="page-top">

<div id="wrapper">

<!-- SIDEBAR -->
<ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion">

    <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon">
            <i class="fas fa-store"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Zupermarket</div>
    </a>

    <hr class="sidebar-divider">

    <li class="nav-item active">
        <a class="nav-link" href="#">
            <i class="fas fa-box"></i>
            <span>Produk</span>
        </a>
    </li>

</ul>

<!-- CONTENT -->
<div id="content-wrapper" class="d-flex flex-column">
<div id="content">

<!-- TOPBAR -->
<nav class="navbar navbar-light bg-white topbar mb-4 shadow">

    <div class="ml-auto d-flex align-items-center">
        <span class="mr-3 text-gray-600 small">
            Login sebagai <b><?= $_SESSION['username']; ?></b>
        </span>

        <a href="../logout.php" class="btn btn-danger btn-sm">
            Logout
        </a>
    </div>

</nav>

<div class="container-fluid">

<!-- HEADER -->
<div class="card shadow mb-4 border-0">
    <div class="card-body d-flex justify-content-between align-items-center">

        <div class="d-flex align-items-center">
            <img src="../Assets/Zupermarket.jpeg"
                 style="width:60px;height:60px;border-radius:10px;object-fit:cover"
                 class="mr-3">

            <div>
                <h5 class="mb-0 font-weight-bold text-success">
                    Dashboard Member
                </h5>
                <small>Halo, <?= $_SESSION['username']; ?></small>
            </div>
        </div>

    </div>
</div>

<div class="card shadow mb-3 border-0">
    <div class="card-body">

        <div class="row">

            <!-- SEARCH -->
            <div class="col-md-6 mb-2">
                <input type="text" id="searchInput" class="form-control"
                       placeholder="Cari produk...">
            </div>

            <!-- FILTER KATEGORI -->
            <div class="col-md-6 mb-2">
                <select id="filterKategori" class="form-control">
                    <option value="all">Semua Kategori</option>
                    <?php foreach($kategori_list as $k): ?>
                        <option value="<?= $k; ?>">
                            <?= ucfirst($k); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>

    </div>
</div>

<!-- GRID PRODUK -->
<div class="row">

<?php foreach($produk as $p): ?>
<div class="col-xl-3 col-md-6 mb-4">

<div class="card shadow clickable" data-id="<?= $p['id']; ?>">

    <img src="Assets-produk/<?= $p['gambar'] ?: 'default.png'; ?>"
         class="card-img-top"
         style="height:180px; object-fit:contain;">

    <div class="card-body text-center">
        <h6><?= $p['nama_barang']; ?></h6>
        <div class="text-success">
            Rp<?= number_format($p['harga_satuan']); ?>
        </div>
        <small class="text-muted">
            Dus: Rp<?= number_format($p['harga_dus']); ?>
        </small>
    </div>

</div>

</div>
<?php endforeach; ?>

</div>

</div>
</div>
</div>

<!-- MODAL -->
<div class="modal fade" id="detailModal">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">

<div class="modal-header">
    <h5 id="modalTitle"></h5>
    <button class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body text-center">

    <img id="modalImage"
         class="img-fluid mb-3"
         style="max-height:200px;border-radius:10px;">

    <p id="modalHarga"></p>
    <p id="modalDus"></p>
    <p id="modalStok"></p>
    <p id="modalDeskripsi"></p>

</div>

</div>
</div>
</div>

<!-- JS -->
<script src="../admin/vendor/jquery/jquery.min.js"></script>
<script src="../admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
const produk = <?= json_encode($produk) ?>;

$(document).on('click', '.clickable', function () {

    let id = $(this).data('id');
    let p = produk.find(x => x.id == id);

    if (!p) return;

    $('#modalTitle').text(p.nama_barang);
    $('#modalImage').attr('src', 'Assets-produk/' + (p.gambar || 'default.png'));

    $('#modalHarga').text('Harga: Rp ' + Number(p.harga_satuan).toLocaleString());
    $('#modalDus').text('Dus: Rp ' + Number(p.harga_dus).toLocaleString());
    $('#modalStok').text('Stok: ' + p.stok_pcs);

    $('#modalDeskripsi').text(
        p.deskripsi ? p.deskripsi : 'Tidak ada deskripsi'
    );

    $('#detailModal').modal('show');
});

    $('#searchInput').on('keyup', function () {
    filterProduk();
});

$('#filterKategori').on('change', function () {
    filterProduk();
});

function filterProduk() {

    let search = $('#searchInput').val().toLowerCase();
    let kategori = $('#filterKategori').val();

    $('.clickable').each(function () {

        let nama = $(this).find('h6').text().toLowerCase();
        let kat = $(this).data('kategori');

        let matchSearch = nama.includes(search);
        let matchKategori = (kategori === 'all' || kat === kategori);

        if (matchSearch && matchKategori) {
            $(this).closest('.col-xl-3').show();
        } else {
            $(this).closest('.col-xl-3').hide();
        }
    });
}
</script>



</body>
</html>