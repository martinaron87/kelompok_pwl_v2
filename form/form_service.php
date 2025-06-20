<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../auth/form_login.php');
    exit();
}
include '../auth/cek_role.php';
adminAtauTeknisi();

include '../databases/koneksi.php';
$query = "SELECT * FROM service;";
$sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Service | Service Gadget</title>

    <!-- Bootstrap & Icons -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.min.css">

    <style>
        .card-modern {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .btn-modern {
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .table-modern tbody tr:hover {
            background-color: #f0f0f0;
            transition: background-color 0.2s ease;
        }
    </style>
</head>

<body class="pt-5 bg-light">

    <!-- Navbar -->
    <nav class="navbar fixed-top bg-primary navbar-dark shadow-sm">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="../halaman_utama.php">
                <img src="../img/menu_logo.png" alt="Logo" width="30" height="30"
                    class="d-inline-block align-text-top me-2">
                Service Gadget
            </a>
        </div>
    </nav>

    <div class="container mt-5 pt-3">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../halaman_utama.php">Halaman Utama</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Service</li>
            </ol>
        </nav>

        <!-- Alert -->
        <?php if (isset($_GET['status'])): ?>
            <?php
            $status = $_GET['status'];
            $alertClass = 'danger';
            $message = 'Terjadi kesalahan.';

            if ($status == 'sukses') {
                $alertClass = 'success';
                $message = 'Data berhasil diproses.';
            } elseif ($status == 'kosong') {
                $alertClass = 'warning';
                $message = 'Semua field wajib diisi.';
            } elseif ($status == 'ubah') {
                $alertClass = 'info';
                $message = 'Data berhasil diubah.';
            } elseif ($status == 'hapus') {
                $alertClass = 'success';
                $message = 'Data berhasil dihapus.';
            }
            ?>
            <div class="alert alert-<?= $alertClass ?> alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i>
                <div><?= $message; ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Judul Halaman + Tombol -->
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <div>
                <h2 class="fw-semibold mb-0">Data Biaya Jasa Service</h2>
                <small class="text-muted">Berisi daftar biaya jasa service yang tersedia di sistem</small>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="../kelola.php?tambah=servis" class="btn btn-primary btn-modern shadow-sm">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Data
                </a>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="card card-modern">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-modern table-hover table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th><i class="bi bi-hash"></i> ID Service</th>
                                <th><i class="bi bi-tools"></i> Jenis Service</th>
                                <th><i class="bi bi-cash-coin"></i> Biaya</th>
                                <th><i class="bi bi-gear-fill"></i> Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($hasil = mysqli_fetch_assoc($sql)): ?>
                                <tr>
                                    <td><?= $hasil['id_service']; ?></td>
                                    <td><?= $hasil['jenis_service']; ?></td>
                                    <td>
                                        <span class="badge bg-success">
                                            Rp <?= number_format($hasil['biaya_service'], 0, ',', '.'); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="../kelola.php?tombol=ubahService&ubah=<?= $hasil['id_service']; ?>"
                                            class="btn btn-sm btn-outline-success btn-modern mb-1">
                                            <i class="bi bi-pencil-square"></i> Ubah
                                        </a>
                                        <a href="../proses.php?hapusService=<?= $hasil['id_service']; ?>"
                                            class="btn btn-sm btn-outline-danger btn-modern mb-1"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        function toggleDarkMode() {
            document.body.classList.toggle("dark-mode");
        }

        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) alert.classList.remove('show');
        }, 3000);
    </script>

</body>

</html>