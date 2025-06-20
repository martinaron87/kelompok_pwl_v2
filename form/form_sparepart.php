<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../auth/form_login.php');
    exit();
}
include '../auth/cek_role.php';
hanyaAdmin();

include '../databases/koneksi.php';

$query = "SELECT * FROM sparepart;";
$sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Sparepart | Service Gadget</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & Icons -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap-icons/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            background-color: #f5f7fa;
        }
    </style>
</head>

<body class="pt-5">

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

    <div class="container mt-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../halaman_utama.php">Halaman Utama</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Sparepart</li>
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
            <div class="alert alert-<?= $alertClass ?> alert-dismissible fade show" role="alert">
                <?= $message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Header dan Tombol -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="fw-semibold mb-0">Data Harga Sparepart</h2>
                <small class="text-muted">Berisi daftar harga sparepart yang tersedia</small>
            </div>
            <div class="d-flex gap-2">
                <a href="../kelola.php?tambah=sparepart" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Data
                </a>
            </div>
        </div>

        <!-- Tabel -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table id="sparepartTable" class="table table-bordered align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-hash"></i> Kode</th>
                            <th><i class="bi bi-cpu-fill"></i> Nama</th>
                            <th><i class="bi bi-cash-coin"></i> Harga</th>
                            <th><i class="bi bi-tags"></i> Jenis</th>
                            <th><i class="bi bi-gem"></i> Merk</th>
                            <th><i class="bi bi-box-seam"></i> Jumlah</th>
                            <th><i class="bi bi-gear-fill"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($hasil = mysqli_fetch_assoc($sql)): ?>
                            <tr>
                                <td><?= $hasil['kd_barang']; ?></td>
                                <td><?= $hasil['nama_barang']; ?></td>
                                <td><span class="badge bg-success">Rp
                                        <?= number_format($hasil['harga_barang'], 0, ',', '.'); ?></span></td>
                                <td><?= $hasil['jenis_barang']; ?></td>
                                <td><?= $hasil['merk_barang']; ?></td>
                                <td><?= $hasil['jumlah_barang']; ?></td>
                                <td>
                                    <a href="../kelola.php?tombol=ubahSparepart&ubah=<?= $hasil['kd_barang']; ?>"
                                        class="btn btn-outline-success btn-sm mb-1">
                                        <i class="bi bi-pencil-square"></i>
                                        Ubah
                                    </a>

                                    <a href="../proses.php?hapusSparepart=<?= $hasil['kd_barang']; ?>"
                                        class="btn btn-outline-danger btn-sm mb-1"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="bi bi-trash"></i>
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#sparepartTable').DataTable();
        });

        function toggleDarkMode() {
            document.body.classList.toggle("dark-mode");
        }
    </script>
</body>

</html>