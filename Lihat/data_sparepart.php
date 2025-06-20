<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../halaman_utama.php?akses=ditolak");
    exit();
}
include '../databases/koneksi.php';
$query = mysqli_query($conn, "SELECT * FROM sparepart");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Sparepart - Service Gadget</title>
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
<body class="pt-4">
<main class="container">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold"><i class="bi bi-cpu-fill me-2"></i>Data Sparepart</h3>
            <p class="text-muted mb-0">Daftar komponen yang tersedia di toko.</p>
        </div>
        <a href="../halaman_utama.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- Tabel -->
    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table id="sparepartTable" class="table table-striped table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Jenis</th>
                        <th>Merk</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><span class="badge bg-secondary"><?= $row['kd_barang'] ?></span></td>
                        <td><?= $row['nama_barang'] ?></td>
                        <td>Rp <?= number_format($row['harga_barang'], 0, ',', '.') ?></td>
                        <td><?= $row['jenis_barang'] ?></td>
                        <td><?= $row['merk_barang'] ?></td>
                        <td><?= $row['jumlah_barang'] ?></td>
                        
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#sparepartTable').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
            }
        });
    });
</script>
</body>
</html>
