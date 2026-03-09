<?php
session_start();
include "Service/koneksi.php";

$alert = "";

if (isset($_POST['simpan'])) {

    $username  = $_POST['username'];
    $email     = $_POST['email'];
    $password  = $_POST['password'];
    $telephone = $_POST['telephone'];

    // cek username
    $cek = mysqli_query($koneksi,"SELECT * FROM member WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        $alert = "<div class='alert alert-danger'>Username <b>$username</b> telah digunakan!</div>";
    } else {

        mysqli_query($koneksi, "
            INSERT INTO member (username, email, password, telephone)
            VALUES ('$username', '$email', '$password', '$telephone')
        ");

        header("Location: memberdash/dashboard.php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<body class="bg-light">
<div class="container mt-5">

<div class="card shadow">
<div class="card-header bg-success text-white">
    <h4>Registrasi</h4>
</div>

<div class="card-body">

<!-- Tampilkan alert jika ada -->
<?php if($alert != "") echo $alert; ?>

<form method="POST">
    <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required>
    </div>

    <div class="mb-3">
    <label>Password</label>
    <div class="input-group">
        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password" required>
        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
            <i class="bi bi-eye"></i>
        </button>
    </div>
</div>

<script>
const toggleBtn = document.getElementById('togglePassword');
const pwInput = document.getElementById('password');

toggleBtn.addEventListener('click', () => {
    if (pwInput.type === 'password') {
        pwInput.type = 'text';
        toggleBtn.innerHTML = '<i class="bi bi-eye-slash"></i>';
    } else {
        pwInput.type = 'password';
        toggleBtn.innerHTML = '<i class="bi bi-eye"></i>';
    }
});
</script>


    <div class="mb-3">
        <label>Telephone<i>(Opsional)</i></label>
        <input type="text" name="telephone" class="form-control" placeholder="Masukkan nomor Telephone (Opsional)">
    </div>

    <button type="submit" name="simpan" class="btn btn-success">
        Tambah Member
    </button>

    <a href="login.php" class="btn btn-primary ms-2">Login</a>
    <a href="admin/fitur/kelola_member/data.php" class="btn btn-secondary ms-2">Kembali</a>
</form>

</div>
</div>

</div>
</body>
</html>
