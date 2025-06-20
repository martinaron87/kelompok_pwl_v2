<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../halaman_utama.php?akses=ditolak");
    exit();
}
include '../databases/koneksi.php';
$query = mysqli_query($conn, "SELECT * FROM pelanggan");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pelanggan - Service Gadget</title>
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
        .table thead {
            background-color: #343a40;
            color: #fff;
        }
    </style>
</head>
<body class="p-4">
    <main class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3><i class="bi bi-person-lines-fill me-2"></i>Data Pelanggan</h3>
            <a href="../halaman_utama.php" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Tabel -->
        <div class="table-responsive">
            <table id="pelangganTable" class="table table-striped table-hover table-bordered align-middle">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>JK</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php while($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?= $row['id_pelanggan'] ?></td>
                        <td><?= $row['nama_pelanggan'] ?></td>
                        <td><?= $row['jenis_kelamin'] ?></td>
                        <td><?= $row['nomor_telepon'] ?></td>
                        <td><?= $row['alamat'] ?></td>
                        <td><?= date('d M Y, H:i', strtotime($row['tanggal'])) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#pelangganTable').DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
                }
            });
        });
    </script>
</body>
</html>
