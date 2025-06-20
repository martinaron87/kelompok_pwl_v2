<?php
session_start();

if (isset($_SESSION['email'])) {
    header('Location: ../halaman_utama.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Service Gadget</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../styles.css">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            background-color: #f5f5f5;
        }
        .form-login {
            max-width: 400px;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <form class="form-login mx-auto" method="post" action="proses_login.php">
            <div class="text-center mb-4">
                <img src="../img/menu_logo.png" alt="Logo" width="80">
                <h1 class="h3 mt-3 fw-normal">Service Gadget</h1>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <script>
                setTimeout(() => {
                    const alert = document.querySelector('.alert');
                    if (alert) {
                        alert.classList.remove('show');
                        alert.classList.add('fade');
                        setTimeout(() => {
                            alert.remove();
                        }, 500);
                    }
                }, 3000);
            </script>
            <?php if (isset($_SESSION['logout'])): ?>
                <div class="alert alert-warning">
                    <?= $_SESSION['logout']; unset($_SESSION['logout']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="user_input" name="user_input" placeholder="Email atau ID Karyawan" required>
                <label for="user_input">Email atau ID Karyawan</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
            </button>

            <p class="mt-3 text-center">Belum Punya Akun?<a href="form_daftar.php" class="ms-2">Daftar Sekarang</a></p>

            <p class="mt-3 me-2 text-center">Kembali Ke Halaman Awal<a href="../index.php" class="ms-2">Halaman Awal</a></p>
            
            <p class="mt-3 mb-3 text-muted text-center">&copy; 2025</p>
        </form>
    </div>
</body>
</html>
