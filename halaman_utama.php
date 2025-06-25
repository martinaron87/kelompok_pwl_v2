<?php
include 'databases/koneksi.php';

session_start();
if (!isset($_SESSION['email'])) {
    header('Location: auth/form_login.php');
    exit();
}

$jumlahPelanggan = $jumlahService = $jumlahSparepart = 0;
if ($_SESSION['role'] === 'admin') {
    $jumlahPelanggan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pelanggan"))['total'];
    $jumlahService = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM service"))['total'];
    $jumlahSparepart = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM sparepart"))['total'];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Service Gadget</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard Admin Service Gadget">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap-icons/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            background-color: #0d6efd;
            color: white;
        }

        .sidebar a {
            color: #ffffffcc;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background-color: #0b5ed7;
            color: #fff;
        }

        .card-hover {
            transition: transform 0.2s ease;
            cursor: pointer;
        }

        .card-hover:hover {
            transform: scale(1.03);
        }

        .brand-logo {
            width: 36px;
            margin-right: 8px;
        }

        .profile-icon {
            font-size: 1.5rem;
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm px-4">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="img/menu_logo.png" class="brand-logo" alt="Logo"> <strong>Service Gadget</strong>
        </a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="text-white">Selamat datang, <?= $_SESSION['username']; ?> <span
                    class="badge bg-light text-dark ms-1"><?= strtoupper($_SESSION['role']); ?></span></span>
        </div>
    </nav>
    <!-- akhir navbar -->
        
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 sidebar p-0 d-none d-md-block">
                <div class="pt-4 text-center fw-bold fs-5">MENU</div>
                <a href="halaman_utama.php" class="active"><i class="bi bi-house me-2"></i>Halaman Utama</a>

                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="form/form_pelanggan.php"><i class="bi bi-person-lines-fill me-2"></i>Data Pelanggan</a>

                    <a href="form/form_service.php"><i class="bi bi-tools me-2"></i>Data Service</a>

                    <a href="form/form_sparepart.php"><i class="bi bi-cpu me-2"></i>Data Sparepart</a>

                    <a href="form/form_transaksi.php"><i class="bi bi-receipt me-2"></i>Transaksi Servis</a>
                <?php endif; ?>

                <a href="auth/logout.php"><i class="bi bi-box-arrow-left me-2"></i>Keluar Akun</a>
            </nav>
            <!-- akhir sidebar -->

            <!-- Main Content -->
            <main class="col-md-10 ms-sm-auto px-4">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mt-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Halaman Utama</li>
                    </ol>
                </nav>

                <!-- Stat Card -->
                <div class="row g-3">
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <div class="col-md-4">
                            <a href="lihat/data_pelanggan.php" class="text-decoration-none">
                                <div class="card bg-light text-dark card-hover shadow-sm text-center">
                                    <div class="card-body">
                                        <i class="bi bi-people-fill fs-1"></i>
                                        <h5 class="mt-2"><?= $jumlahPelanggan ?></h5>
                                        <p class="mb-0">Total Pelanggan</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="col-md-4">
                        <a href="lihat/data_service.php" class="text-decoration-none">
                            <div class="card bg-light text-dark card-hover shadow-sm text-center">
                                <div class="card-body">
                                    <i class="bi bi-tools fs-1"></i>
                                    <h5 class="mt-2"><?= $jumlahService ?></h5>
                                    <p class="mb-0">Jenis Service</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <div class="col-md-4">
                            <a href="lihat/data_sparepart.php" class="text-decoration-none">
                                <div class="card bg-light text-dark card-hover shadow-sm text-center">
                                    <div class="card-body">
                                        <i class="bi bi-cpu-fill fs-1"></i>
                                        <h5 class="mt-2"><?= $jumlahSparepart ?></h5>
                                        <p class="mb-0">Data Sparepart</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-12">
                            <a href="lihat/data_transaksi.php" class="text-decoration-none">
                                <div class="card bg-light text-dark card-hover shadow-sm text-center">
                                    <div class="card-body">
                                        <i class="bi bi-cash-coin fs-1"></i>
                                        <h5 class="mt-2">Transaksi</h5>
                                        <p class="mb-0">Riwayat Service & Pembayaran</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
    <!-- akhir main content -->

    <!-- Scripts -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>

</html>