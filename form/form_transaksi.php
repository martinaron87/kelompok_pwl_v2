<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../auth/form_login.php');
    exit();
}
include '../auth/cek_role.php';
hanyaAdmin();

include '../databases/koneksi.php';

$query = "SELECT ts.*, p.nama_pelanggan, s.jenis_service 
          FROM transaksi ts
          JOIN pelanggan p ON ts.id_pelanggan = p.id_pelanggan
          JOIN service s ON ts.id_service = s.id_service";
$sql = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Transaksi | Service Gadget</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../styles.css">
</head>

<body class="pt-5">
    <!-- navbar -->
    <nav class="navbar fixed-top bg-primary navbar-dark shadow-sm">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="../halaman_utama.php">
                <img src="../img/menu_logo.png" alt="Logo" width="30" height="30"
                    class="d-inline-block align-text-top me-2">
                Service Gadget
            </a>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Alert -->
        <?php if (isset($_GET['status'])): ?>
            <?php
            $status = $_GET['status'];
            $alertClass = match ($status) {
                'sukses' => 'success',
                'ubah' => 'info',
                'hapus' => 'success',
                'kosong' => 'warning',
                'gagal' => 'danger',
                default => 'secondary',
            };
            $message = match ($status) {
                'sukses' => 'Data transaksi berhasil ditambahkan.',
                'ubah' => 'Data transaksi berhasil diubah.',
                'hapus' => 'Data transaksi berhasil dihapus.',
                'kosong' => 'Semua field wajib diisi.',
                'gagal' => 'Terjadi kesalahan saat memproses data.',
                default => 'Status tidak diketahui.',
            };
            ?>
            <div class="alert alert-<?= $alertClass ?> alert-dismissible fade show" role="alert">
                <?= $message ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light px-3 py-2 rounded">
                <li class="breadcrumb-item"><a href="../halaman_utama.php">Halaman Utama</a></li>
                <li class="breadcrumb-item active" aria-current="page">Data Transaksi</li>
            </ol>
        </nav>

        <!-- Title -->
        <div>
            <h2 class="fw-semibold mb-0">Data Transaksi</h2>
            <small class="text-muted">Berisi transaksi yang tersedia</small>
        </div>

        <!-- Tombol Aksi -->
        <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
            <a href="../kelola.php?tambah=transaksi" class="btn btn-primary">
                <i class="bi bi-receipt-cutoff me-2"></i>Tambah Transaksi
            </a>
        </div>

        <!-- Tabel -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Pelanggan</th>
                        <th>Service</th>
                        <th>Tanggal Masuk</th>
                        <th>Kerusakan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($sql)): ?>
                        <tr>
                            <td><span class="badge bg-dark"><?= $row['id_transaksi'] ?></span></td>

                            <td><?= $row['nama_pelanggan'] ?></td>

                            <td><?= $row['jenis_service'] ?></td>
                            
                            <td><?= $row['tanggal_masuk'] ?></td>

                            <td><?= $row['kerusakan'] ?></td>
                            
                            <td>
                                <a href="../proses.php?hapusTransaksi=<?= $row['id_transaksi'] ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
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

    <script>
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }, 3000);
    </script>

</body>

</html>