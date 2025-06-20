<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../halaman_utama.php?akses=ditolak");
    exit();
}
include '../databases/koneksi.php';
$query = mysqli_query($conn, "SELECT * FROM service");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Service - Service Gadget</title>
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
            <h3 class="fw-bold"><i class="bi bi-tools me-2"></i>Data Jenis Service</h3>
            <p class="text-muted mb-0">Daftar jenis layanan yang tersedia beserta biayanya.</p>
        </div>
        <a href="../halaman_utama.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <!-- Tabel -->
    <div class="card shadow-sm border-0">
        <div class="card-body table-responsive">
            <table id="serviceTable" class="table table-bordered table-striped align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Jenis Service</th>
                        <th>Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($query)): ?>
                        <tr>
                            <td><span class="badge bg-secondary"><?= $row['id_service'] ?></span></td>
                            <td><?= $row['jenis_service'] ?></td>
                            <td><strong>Rp <?= number_format($row['biaya_service'], 0, ',', '.') ?></strong></td>
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
        $('#serviceTable').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
            }
        });
    });
</script>
</body>
</html>
