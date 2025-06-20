<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../auth/form_login.php');
    exit();
}
include '../auth/cek_role.php';
hanyaAdmin();

include '../databases/koneksi.php';
$query = "SELECT * FROM pelanggan;";
$sql = mysqli_query($conn, $query) or die(mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan | Service Gadget</title>

    <!-- Bootstrap & Icons -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.min.css">
</head>
<body class="bg-light pt-5">

<!-- Navbar -->
<nav class="navbar fixed-top bg-primary navbar-dark shadow-sm">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="../halaman_utama.php">
            <img src="../img/menu_logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top me-2">
            Service Gadget
        </a>
    </div>
</nav>


<div class="container mt-5">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../halaman_utama.php">Halaman Utama</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Pelanggan</li>
        </ol>
    </nav>

    <!-- ALERT -->
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
                'sukses' => 'Data berhasil ditambahkan.',
                'ubah' => 'Data berhasil diubah.',
                'hapus' => 'Data berhasil dihapus.',
                'kosong' => 'Semua field wajib diisi.',
                'gagal' => 'Terjadi kesalahan saat memproses data.',
                default => 'Status tidak diketahui.',
            };
        ?>
        <div class="alert alert-<?= $alertClass ?> alert-dismissible fade show mt-3 shadow-sm" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i> <?= $message ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Judul + Tombol -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
        <div>
            <h2 class="fw-semibold mb-0">Data Pelanggan</h2>
            <small class="text-muted">Berisi daftar pelanggan yang sudah terdaftar</small>
        </div>
        <div class="d-flex gap-2">
            <a href="../kelola.php?tambah=pelanggan" class="btn btn-primary shadow-sm">
                <i class="bi bi-person-plus-fill me-2"></i> Tambah Data
            </a>
        </div>
    </div>

    <!-- Tabel -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th><i class="bi bi-hash"></i> ID</th>
                        <th><i class="bi bi-person-circle"></i> Nama</th>
                        <th><i class="bi bi-gender-ambiguous"></i> JK</th>
                        <th><i class="bi bi-telephone-fill"></i> Telepon</th>
                        <th><i class="bi bi-geo-alt-fill"></i> Alamat</th>
                        <th><i class="bi bi-calendar-date"></i> Tanggal</th>
                        <th><i class="bi bi-gear-fill"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php while ($hasil = mysqli_fetch_assoc($sql)): ?>
                        <tr>
                            <td><span class="badge bg-dark"><?= $hasil['id_pelanggan']; ?></span></td>
                            <td><?= $hasil['nama_pelanggan']; ?></td>
                            <td><?= $hasil['jenis_kelamin']; ?></td>
                            <td><?= $hasil['nomor_telepon']; ?></td>
                            <td class="text-start"><?= $hasil['alamat']; ?></td>
                            <td><?= $hasil['tanggal']; ?></td>
                            <td>
                                <a href="../kelola.php?tombol=ubahPelanggan&ubah=<?= $hasil['id_pelanggan']; ?>" class="btn btn-outline-success btn-sm mb-1">
                                    <i class="bi bi-pencil-square"></i>
                                    Ubah
                                </a>
                                <a href="../proses.php?hapus=<?= $hasil['id_pelanggan']; ?>" class="btn btn-outline-danger btn-sm mb-1" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="bi bi-trash-fill"></i>
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

<!-- Script Dark Mode -->
<script>
    function toggleDarkMode() {
        document.body.classList.toggle("dark-mode");
    }

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
