<?php

session_start();
include "Service/koneksi.php";

// kalau sudah login → lempar ke dashboard
if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: memberdash/dashboard.php");
    }
    exit;
}

$error = "";

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($koneksi,"SELECT * FROM member WHERE username='$username' AND password='$password'");

    if (mysqli_num_rows($query) > 0) {

        $data = mysqli_fetch_assoc($query);

        $_SESSION['login'] = true;
        $_SESSION['username'] = $data['username'];
        $_SESSION['id'] = $data['id'];
        $_SESSION['role'] = $data['role'];

        if ($data['role'] == 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: memberdash/dashboard.php");
        }
        exit;

    } else {
        $error = "Username / Password salah!";
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Login Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

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


<body class="bg-light">

<div class="container mt-5">
<div class="row justify-content-center">
<div class="col-md-4">

<div class="card shadow">
<div class="card-header bg-primary text-white text-center">
    <h4>Form Login</h4>
</div>

<div class="card-body">

<?php if (!empty($error)) : ?>
<div class="alert alert-danger"><?= $error; ?></div>
<?php endif; ?>

<form method="POST">

    <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
    </div>

    <div class="mb-3">
   <div class="mb-3">
    <label>Password</label>
    <div class="input-group">
        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password" required>
        <button type="button" id="togglePassword" class="btn btn-outline-secondary">
            <i class="bi bi-eye"></i>
        </button>
    </div>
</div>

</div>
    <button type="submit" name="login" class="btn btn-primary w-100">
        Login
    </button>

    <a href="tambah.php" class="btn btn-secondary w-100 mt-2">
        Kembali
    </a>

</form>

</div>
</div>

</div>
</div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const toggleBtn = document.getElementById('togglePassword');
    const pwInput = document.getElementById('password');

    toggleBtn.addEventListener('click', function () {
        if (pwInput.type === 'password') {
            pwInput.type = 'text';
            toggleBtn.innerHTML = '<i class="bi bi-eye-slash"></i>';
        } else {
            pwInput.type = 'password';
            toggleBtn.innerHTML = '<i class="bi bi-eye"></i>';
        }
    });

});
</script>

</body>
</html>
