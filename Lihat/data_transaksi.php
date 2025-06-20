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
          JOIN service s ON ts.id_service = s.id_service
          ";
$sql = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Transaksi - Service Gadget</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap-icons/bootstrap-icons.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body class="pt-5">
<nav class="navbar fixed-top bg-white shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="../halaman_utama.php">
            <img src="../img/menu_logo.png" alt="Logo" width="30" class="d-inline-block align-text-top">
            Service Gadget
        </a>
    </div>
</nav>

<main class="container mt-5 pt-4">
    <!-- Alert -->
    <?php if (isset($_GET['status'])): ?>
        <?php
        $status = $_GET['status'];
        $alertClass = match($status) {
            'sukses' => 'success',
            'ubah' => 'info',
            'hapus' => 'success',
            'kosong' => 'warning',
            'gagal' => 'danger',
            default => 'secondary',
        };
        $message = match($status) {
            'sukses' => 'Transaksi berhasil disimpan.',
            'ubah' => 'Data transaksi berhasil diubah.',
            'hapus' => 'Data transaksi berhasil dihapus.',
            'kosong' => 'Semua field wajib diisi.',
            'gagal' => 'Terjadi kesalahan saat memproses transaksi.',
            default => 'Status tidak diketahui.',
        };
        ?>
        <div class="alert alert-<?= $alertClass ?> alert-dismissible fade show" role="alert">
            <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    <?php endif; ?>

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold"><i class="bi bi-receipt-cutoff me-2"></i>Data Transaksi</h3>
            <p class="text-muted mb-0">Daftar transaksi layanan service pelanggan.</p>
        </div>
        <a href="../halaman_utama.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- Table -->
    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table id="transaksiTable" class="table table-striped table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Pelanggan</th>
                        <th>Service</th>
                        <th>Tanggal Masuk</th>
                        <th>Kerusakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($sql)): ?>
                        <tr>
                            <td><?= $row['id_transaksi'] ?></td>
                            
                            <td><?= $row['nama_pelanggan'] ?></td>

                            <td><?= $row['jenis_service'] ?></td> 

                            <td><?= date('d M Y', strtotime($row['tanggal_masuk'])) ?></td>

                            <td><?= $row['kerusakan'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- DataTables -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#transaksiTable').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
            }
        });
    });
</script>
</body>
</html>
