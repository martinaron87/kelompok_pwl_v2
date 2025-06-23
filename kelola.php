<?php
include 'databases/koneksi.php';

// Auto-generate ID Pelanggan
$queryP = "SELECT id_pelanggan FROM pelanggan ORDER BY id_pelanggan DESC LIMIT 1";
$resP = mysqli_query($conn, $queryP);
$lastP = mysqli_fetch_assoc($resP);
$newIdPelanggan = $lastP ? 'PLG' . str_pad((int) substr($lastP['id_pelanggan'], 3) + 1, 3, '0', STR_PAD_LEFT) : 'PLG001';

// Auto-generate ID Service
$queryS = "SELECT id_service FROM service ORDER BY id_service DESC LIMIT 1";
$resS = mysqli_query($conn, $queryS);
$lastS = mysqli_fetch_assoc($resS);
$newIdService = $lastS ? 'SRV' . str_pad((int) substr($lastS['id_service'], 3) + 1, 3, '0', STR_PAD_LEFT) : 'SRV001';

// Auto-generate kode barang sparepart
$querySP = "SELECT kd_barang FROM sparepart ORDER BY kd_barang DESC LIMIT 1";
$resSP = mysqli_query($conn, $querySP);
$lastSP = mysqli_fetch_assoc($resSP);
$newKodeBarang = $lastSP ? 'SP' . str_pad((int) substr($lastSP['kd_barang'], 2) + 1, 3, '0', STR_PAD_LEFT) : 'SP001';

$tanggal = date("Ymd");
$acak = rand(1000, 999999);
$id_transaksi = "TR$tanggal$acak";
$tanggal_masuk = date("yyyy-MM-dd");
$pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan");
$service = mysqli_query($conn, "SELECT * FROM service");
$teknisi = mysqli_query($conn, "SELECT * FROM karyawan WHERE posisi = 'teknisi'");
$sparepart = mysqli_query($conn, "SELECT * FROM sparepart");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons.min.css">
    <!-- akhir bootstrap -->

    <!-- css sendiri -->
    <link rel="stylesheet" href="styles.css">
    <!-- akhir css sendiri -->

    <title>Service Gadget</title>
</head>

<body class="pt-5">
    <!-- navbar -->
    <nav class="navbar fixed-top bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="img/menu_logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                Service Gadget
            </a>
        </div>
    </nav>
    <!-- akhir navbar -->

    <div class="container">
        <?php if (isset($_GET['tambah']) && $_GET['tambah'] == 'pelanggan'): ?>
            <!-- judul input pelanggan-->
            <h1 class="mt-3 text-center">Tambah Data Pelanggan</h1>
            <figure class="text-center">
                <blockquote class="blockquote">
                    <p>Formulir untuk menginput data pelanggan</p>
                </blockquote>

            <?php elseif (isset($_GET['tambah']) && $_GET['tambah'] == 'servis'): ?>
                <!-- judul input jasa servis-->
                <h1 class="mt-3 text-center">Tambah Data Jasa Service</h1>
                <figure class="text-center">
                    <blockquote class="blockquote">
                        <p>Formulir untuk menginput jenis dan biaya jasa service yang tersedia di toko Service Gadget</p>
                    </blockquote>

                <?php elseif (isset($_GET['tambah']) && $_GET['tambah'] == 'sparepart'): ?>
                    <!-- judul input spraepart-->
                    <h1 class="mt-3 text-center">Tambah Data Barang Sparepart</h1>
                    <figure class="text-center">
                        <blockquote class="blockquote">
                            <p>Formulir untuk menginput harga sparepart yang tersedia di toko Service Gadget</p>
                        </blockquote>
                    <?php endif; ?>


                    <?php if (isset($_GET['tombol']) && $_GET['tombol'] == 'ubahPelanggan'): ?>
                        <!-- judul ubah pelanggan-->
                        <h1 class="mt-3 text-center">Pengubahan Data Pelanggan</h1>
                        <figure class="text-center">
                            <blockquote class="blockquote">
                                <p>Formulir untuk mengubah data pelanggan</p>
                            </blockquote>

                        <?php elseif (isset($_GET['tombol']) && $_GET['tombol'] == 'ubahService'): ?>
                            <!-- judul ubah jasa servis-->
                            <h1 class="mt-3 text-center">Pengubahan Data Jenis Jasa Service</h1>
                            <figure class="text-center">
                                <blockquote class="blockquote">
                                    <p>Formulir untuk mengubah data jenis jasa service</p>
                                </blockquote>

                            <?php elseif (isset($_GET['tombol']) && $_GET['tombol'] == 'ubahSparepart'): ?>
                                <!-- judul ubah sparepart -->
                                <h1 class="mt-3 text-center">Pengubahan Data Sparepart</h1>
                                <figure class="text-center">
                                    <blockquote class="blockquote">
                                        <p>Formulir untuk mengubah data sparepart</p>
                                    </blockquote>

                                <?php endif; ?>

                                <figcaption class="blockquote-footer">
                                    CRUD - <cite title="Source Title">Create, Read, Update, Delete</cite>
                                </figcaption>
                            </figure>
                            <!-- akhir judul -->


                            <!-- form input pelanggan, servis, sparepart -->
                            <?php if (isset($_GET['tambah']) && $_GET['tambah'] == 'pelanggan'): ?>
                                <div class="container d-flex justify-content-center align-items-center my-5">
                                    <div class="col-lg-8">
                                        <div class="card shadow border-0 rounded-4">
                                            <div class="card-header bg-primary text-white rounded-top-4">
                                                <h4 class="mb-0"><i class="bi bi-person-plus-fill me-2"></i>Tambah Data
                                                    Pelanggan</h4>
                                            </div>

                                            <div class="card-body p-4 bg-light rounded-bottom-4">
                                                <!-- form pelanggan -->
                                                <form action="proses.php?tambah=pelanggan" method="post"
                                                    class="needs-validation" novalidate>

                                                    <!-- ID Pelanggan -->
                                                    <div class="mb-3">
                                                        <label for="idPelanggan" class="form-label">ID Pelanggan</label>
                                                        <input type="text"
                                                            class="form-control bg-light border-0 text-muted fw-semibold"
                                                            name="idPelanggan" id="idPelanggan"
                                                            value="<?= $newIdPelanggan ?>" readonly>
                                                    </div>
                                                    <!-- akhir id pelanggan -->

                                                    <!-- Nama Pelanggan -->
                                                    <div class="mb-3">
                                                        <label for="namaPelanggan" class="form-label">Nama Pelanggan</label>
                                                        <input type="text" class="form-control" name="namaPelanggan"
                                                            id="namaPelanggan" required>
                                                    </div>
                                                    <!-- akhir nama pelanggan -->

                                                    <!-- Jenis Kelamin -->
                                                    <div class="mb-3">
                                                        <label class="form-label d-block">Jenis Kelamin</label>

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="jenis_kelamin" value="Pria" id="pria" required>
                                                            <label class="form-check-label" for="pria">Pria</label>
                                                        </div>

                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="jenis_kelamin" value="Wanita" id="wanita">
                                                            <label class="form-check-label" for="wanita">Wanita</label>
                                                        </div>
                                                    </div>
                                                    <!-- akhir jenis kelamin -->

                                                    <!-- Nomor Telepon -->
                                                    <div class="mb-3">
                                                        <label for="nomorTelepon" class="form-label">Nomor Telepon</label>
                                                        <input type="tel" class="form-control" name="nomorTelepon"
                                                            id="nomorTelepon" required>
                                                    </div>
                                                    <!-- akhir nomor telepon -->

                                                    <!-- Alamat -->
                                                    <div class="mb-3">
                                                        <label for="alamat" class="form-label">Alamat Pelanggan</label>
                                                        <textarea class="form-control" name="alamat" id="alamat" rows="3"
                                                            required></textarea>
                                                    </div>
                                                    <!-- akhir alamat -->

                                                    <!-- Tanggal -->
                                                    <div class="mb-4">
                                                        <label for="tanggal" class="form-label">Tanggal</label>
                                                        <input type="datetime-local" class="form-control" id="tanggal"
                                                            name="tanggal" required>
                                                    </div>
                                                    <!-- akhir tanggal -->

                                                    <!-- Tombol -->
                                                    <div class="d-flex justify-content-between">
                                                        <a href="form/form_pelanggan.php" class="btn btn-outline-secondary">
                                                            <i class="bi bi-arrow-return-left me-2"></i>Batal
                                                        </a>

                                                        <button type="submit" name="aksi" value="tambah"
                                                            class="btn btn-primary">
                                                            <i class="bi bi-plus-square-fill me-2"></i>Tambah Data
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- akhir form input pelanggan-->


                                <!-- form input service-->
                            <?php elseif (isset($_GET['tambah']) && $_GET['tambah'] == 'servis'): ?>
                                <div class="container d-flex justify-content-center align-items-center my-5">
                                    <div class="col-lg-8">
                                        <div class="card shadow border-0 rounded-4">
                                            <div class="card-header bg-primary text-white rounded-top-4">
                                                <h4 class="mb-0"><i class="bi bi-tools me-2"></i>Tambah Jenis Jasa Service
                                                </h4>
                                            </div>


                                            <div class="card-body p-4 bg-light rounded-bottom-4">

                                                <!-- form servis -->
                                                <form action="proses.php?tambah=servis" method="post"
                                                    class="needs-validation" novalidate>
                                                    <!-- ID Service -->
                                                    <div class="mb-3">
                                                        <label for="idService" class="form-label">ID Service</label>
                                                        <input type="text"
                                                            class="form-control bg-light border-0 text-muted fw-semibold"
                                                            name="idService" id="idService" value="<?= $newIdService ?>"
                                                            readonly>
                                                    </div>

                                                    <!-- Jenis Service -->
                                                    <div class="mb-3">
                                                        <label for="jenisService" class="form-label">Jenis Service</label>
                                                        <input type="text" class="form-control" name="jenisService"
                                                            id="jenisService" required>
                                                    </div>

                                                    <!-- Biaya Service -->
                                                    <div class="mb-4">
                                                        <label for="biayaService" class="form-label">Biaya Service
                                                            (Rp)</label>
                                                        <input type="number" class="form-control" name="biayaService"
                                                            id="biayaService" required>
                                                    </div>

                                                    <!-- Tombol -->
                                                    <div class="d-flex justify-content-between">
                                                        <a href="form/form_service.php" class="btn btn-outline-secondary">
                                                            <i class="bi bi-arrow-return-left me-2"></i>Batal
                                                        </a>

                                                        <button type="submit" name="aksi" value="tambah"
                                                            class="btn btn-primary">
                                                            <i class="bi bi-plus-square-fill me-2"></i>Tambah Data
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- akhir form input jenis jasa service-->


                                <!-- form input sparepart -->
                            <?php elseif (isset($_GET['tambah']) && $_GET['tambah'] == 'sparepart'): ?>
                                <div class="container d-flex justify-content-center align-items-center my-5">
                                    <div class="col-lg-8">
                                        <div class="card shadow border-0 rounded-4">
                                            <div class="card-header bg-primary text-white rounded-top-4">
                                                <h4 class="mb-0"><i class="bi bi-cpu-fill me-2"></i>Tambah Data Sparepart
                                                </h4>
                                            </div>

                                            <div class="card-body bg-light rounded-bottom-4">
                                                <!-- form sparepart-->
                                                <form action="proses.php?tambah=sparepart" method="post"
                                                    class="needs-validation" novalidate>

                                                    <!-- Kode Barang (Auto ID) -->
                                                    <div class="mb-3">
                                                        <label for="kodeBarang" class="form-label">Kode Barang</label>
                                                        <input type="text"
                                                            class="form-control bg-light border-0 text-muted fw-semibold"
                                                            name="kodeBarang" id="kodeBarang" value="<?= $newKodeBarang; ?>"
                                                            readonly>
                                                    </div>

                                                    <!-- Nama Barang -->
                                                    <div class="mb-3">
                                                        <label for="namaBarang" class="form-label">Nama Barang</label>
                                                        <input type="text" class="form-control" name="namaBarang"
                                                            id="namaBarang" required>
                                                    </div>

                                                    <!-- Harga Barang -->
                                                    <div class="mb-3">
                                                        <label for="hargaBarang" class="form-label">Harga Barang
                                                            (Rp)</label>
                                                        <input type="number" class="form-control" name="hargaBarang"
                                                            id="hargaBarang" required>
                                                    </div>

                                                    <!-- Jenis Barang -->
                                                    <div class="mb-3">
                                                        <label for="jenisBarang" class="form-label">Jenis Barang</label>
                                                        <input type="text" class="form-control" name="jenisBarang"
                                                            id="jenisBarang" required>
                                                    </div>

                                                    <!-- Merk Barang -->
                                                    <div class="mb-3">
                                                        <label for="merkBarang" class="form-label">Merk Barang</label>
                                                        <input type="text" class="form-control" name="merkBarang"
                                                            id="merkBarang" required>
                                                    </div>

                                                    <!-- Jumlah Barang -->
                                                    <div class="mb-4">
                                                        <label for="jumlahBarang" class="form-label">Jumlah Barang</label>
                                                        <input type="number" class="form-control" name="jumlahBarang"
                                                            id="jumlahBarang" required>
                                                    </div>

                                                    <!-- Tombol Aksi -->
                                                    <div class="d-flex justify-content-between">
                                                        <a href="form/form_sparepart.php" class="btn btn-outline-secondary">
                                                            <i class="bi bi-arrow-return-left me-2"></i>Batal
                                                        </a>

                                                        <button type="submit" name="aksi" value="tambah"
                                                            class="btn btn-primary">
                                                            <i class="bi bi-plus-square-fill me-2"></i>Tambah Data
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- akhir form input sparepart-->

                                <!-- form input transaksi -->
                            <?php elseif ((isset($_GET['tambah']) && $_GET['tambah'] == 'transaksi') || (isset($_GET['tombol']) && $_GET['tombol'] == 'tambahTransaksi')): ?>

                                <h2 class="fw-bold text-center">Tambah Data Transaksi</h2>
                                <p class="text-center text-muted">Formulir untuk menginput data transaksi<br><em>— CRUD:
                                        Create, Read, Update, Delete</em></p>

                                <form action="proses.php?tambah=transaksi" method="post">

                                    <!-- ID Transaksi -->
                                    <div class="container my-5">
                                        <div class="col-lg-8 mx-auto">
                                            <div class="card shadow-sm border-0 rounded-4">
                                                <div class="card-header bg-primary text-white rounded-top-4">
                                                    <h4 class="mb-0"><i class="bi bi-receipt-cutoff me-2"></i>Tambah Data
                                                        Transaksi</h4>
                                                </div>
                                                <div class="card-body bg-light rounded-bottom-4">
                                                    <form action="proses.php?tambah=transaksi" method="post">
                                                        <input type="hidden" name="aksi" value="tambah">

                                                        <!-- ID Transaksi -->
                                                        <div class="mb-3">
                                                            <label for="id_transaksi" class="form-label">ID
                                                                Transaksi</label>
                                                            <input type="text"
                                                                class="form-control bg-light border-0 text-muted fw-semibold"
                                                                name="id_transaksi" value="<?= $id_transaksi ?>" readonly>
                                                        </div>

                                                        <!-- Pelanggan -->
                                                        <div class="mb-3">
                                                            <label for="id_pelanggan" class="form-label">Pelanggan</label>
                                                            <select class="form-select" name="id_pelanggan"
                                                                id="id_pelanggan" required>
                                                                <option value="">-- Pilih Pelanggan --</option>
                                                                <?php while ($row = mysqli_fetch_assoc($pelanggan)): ?>
                                                                    <option value="<?= $row['id_pelanggan'] ?>">
                                                                        <?= $row['nama_pelanggan'] ?></option>
                                                                <?php endwhile; ?>
                                                            </select>
                                                        </div>

                                                        <!-- Service -->
                                                        <div class="mb-3">
                                                            <label for="id_service" class="form-label">Jenis Service</label>
                                                            <select class="form-select" name="id_service" required>
                                                                <option value="">-- Pilih Jenis Service --</option>
                                                                <?php while ($row = mysqli_fetch_assoc($service)): ?>
                                                                    <option value="<?= $row['id_service'] ?>">
                                                                        <?= $row['jenis_service'] ?></option>
                                                                <?php endwhile; ?>
                                                            </select>
                                                        </div>

                                                        <!-- Tanggal -->
                                                        <div class="mb-3">
                                                            <label for="tanggal_masuk" class="form-label">Tanggal
                                                                Masuk</label>
                                                            <input type="date" class="form-control" name="tanggal_masuk"
                                                                id="tanggal_masuk" value="<?= $tanggal_masuk ?>">
                                                        </div>

                                                        <!-- Kerusakan -->
                                                        <div class="mb-3">
                                                            <label for="kerusakan" class="form-label">Rician
                                                                Kerusakan</label>
                                                            <textarea class="form-control" name="kerusakan"
                                                                required></textarea>
                                                        </div>

                                                        <!-- Sparepart Dinamis -->
                                                        <div class="mb-3">
                                                            <label class="form-label">Sparepart & Jumlah</label>
                                                            <div id="sparepart-section">
                                                                <div class="input-group mb-2">
                                                                    <select name="sparepart[]" class="form-select me-2">
                                                                        <option value="-- PIlih Sparepart --" selected>-- Pilih Jenis Sparepart --</option>
                                                                        <option value="null">Tidak Butuh Pergantian</option>
                                                                        <?php mysqli_data_seek($sparepart, 0);
                                                                        while ($s = mysqli_fetch_assoc($sparepart)): ?>
                                                                            <option value="<?= $s['kd_barang'] ?>">
                                                                                <?= $s['nama_barang'] ?> -
                                                                                Rp<?= $s['harga_barang'] ?></option>
                                                                        <?php endwhile; ?>
                                                                    </select>
                                                                    <input type="number" name="jumlah[]"
                                                                        class="form-control" placeholder="Jumlah">
                                                                </div>
                                                            </div>
                                                            <button type="button" onclick="tambahSparepart()"
                                                                class="btn btn-outline-secondary btn-sm mt-1">Tambah
                                                                Sparepart Baru</button>
                                                        </div>

                                                        <script>
                                                            function tambahSparepart() {
                                                                const section = document.getElementById('sparepart-section');
                                                                const clone = section.children[0].cloneNode(true);
                                                                section.appendChild(clone);
                                                            }
                                                        </script>


                                                        <!-- Tombol -->
                                                        <div class="d-flex justify-content-between mt-4">
                                                            <a href="form/form_transaksi.php" class="btn btn-danger">
                                                                <i class="bi bi-arrow-return-left me-2"></i>Batal
                                                            </a>

                                                            <button type="submit" class="btn btn-primary" name="aksi"
                                                                value="tambah">
                                                                <i class="bi bi-plus-circle me-2"></i>Simpan Transaksi
                                                            </button>
                                                        </div>
                                                        <!-- akhir tombol -->
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
    </div>
    <script>
        document.getElementById('id_pelanggan').addEventListener('change', function () {
            const idPelanggan = this.value;

            if (idPelanggan) {
                console.log("Mengirim request untuk id_pelanggan: " + idPelanggan);
                fetch('get_tanggal.php?id_pelanggan=' + idPelanggan)
                    .then(response => response.json())
                    .then(data => {
                        console.log("Response dari server:", data);
                        if (data.success) {
                            document.getElementById('tanggal_masuk').value = data.tanggal_masuk;
                        } else {
                            alert('Tanggal masuk tidak ditemukan!');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });

    </script>

</body>

</html>

<!-- FORM UBAH / EDIT -->
<?php
include 'databases/koneksi.php';

if (isset($_GET['tombol']) && isset($_GET['ubah'])):
    $tombol = $_GET['tombol'];
    $id = $_GET['ubah'];
    $data = [];
    $cancel = "";

    switch ($tombol) {
        case 'ubahPelanggan':
            $query = "SELECT * FROM pelanggan WHERE id_pelanggan = '$id'";
            $sql = mysqli_query($conn, $query);
            $data = mysqli_fetch_assoc($sql);
            $cancel = "pelanggan.php";
            ?>
            <form action="proses.php?formUbah=pelanggan" method="post">
                <input type="hidden" name="idPelanggan" value="<?= $id ?>">
                <!-- Nama -->
                <div class="mb-3 row justify-content-center">
                    <label class="col-sm-2 col-form-label">Nama Pelanggan</label>
                    <div class="col-sm-6">
                        <input type="text" name="namaPelanggan" class="form-control" value="<?= $data['nama_pelanggan'] ?>">
                    </div>
                </div>
                <!-- Gender -->
                <div class="mb-3 row justify-content-center">
                    <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-6">
                        <?php $jk = $data['jenis_kelamin']; ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" value="Pria" <?= ($jk == 'Pria') ? 'checked' : '' ?>> Pria
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" value="Wanita" <?= ($jk == 'Wanita') ? 'checked' : '' ?>> Wanita
                        </div>
                    </div>
                </div>
                <!-- Telepon, Alamat, Tanggal -->
                <div class="mb-3 row justify-content-center">
                    <label class="col-sm-2 col-form-label">Nomor Telepon</label>
                    <div class="col-sm-6">
                        <input type="text" name="nomorTelepon" class="form-control" value="<?= $data['nomor_telepon'] ?>">
                    </div>
                </div>
                <div class="mb-3 row justify-content-center">
                    <label class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-6">
                        <textarea name="alamat" class="form-control"><?= $data['alamat'] ?></textarea>
                    </div>
                </div>
                <div class="mb-3 row justify-content-center">
                    <label class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-6">
                        <input type="datetime-local" name="tanggal" class="form-control" value="<?= $data['tanggal'] ?>">
                    </div>
                </div>
                <!-- Tombol -->
                <?php $cancel = "form/form_pelanggan.php"; ?>
                <?php break;

        case 'ubahService':
            $query = "SELECT * FROM service WHERE id_service = '$id'";
            $sql = mysqli_query($conn, $query);
            $data = mysqli_fetch_assoc($sql); ?>

                <form action="proses.php?formUbah=servis" method="post">
                    <input type="hidden" name="idService" value="<?= $id ?>">
                    <div class="mb-3 row justify-content-center">
                        <label class="col-sm-2 col-form-label">Jenis Service</label>
                        <div class="col-sm-6">
                            <input type="text" name="jenisService" class="form-control" value="<?= $data['jenis_service'] ?>">
                        </div>
                    </div>
                    <div class="mb-3 row justify-content-center">
                        <label class="col-sm-2 col-form-label">Biaya</label>
                        <div class="col-sm-6">
                            <input type="number" name="biayaService" class="form-control" value="<?= $data['biaya_service'] ?>">
                        </div>
                    </div>
                    <?php $cancel = "form/form_service.php"; ?>
                    <?php break;

        case 'ubahSparepart':
            $query = "SELECT * FROM sparepart WHERE kd_barang = '$id'";
            $sql = mysqli_query($conn, $query);
            $data = mysqli_fetch_assoc($sql); ?>

                    <form action="proses.php?formUbah=sparepart" method="post">
                        <input type="hidden" name="kodeBarang" value="<?= $id ?>">
                        <div class="mb-3 row justify-content-center">
                            <label class="col-sm-2 col-form-label">Nama Barang</label>
                            <div class="col-sm-6">
                                <input type="text" name="namaBarang" class="form-control" value="<?= $data['nama_barang'] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row justify-content-center">
                            <label class="col-sm-2 col-form-label">Harga</label>
                            <div class="col-sm-6">
                                <input type="number" name="hargaBarang" class="form-control" value="<?= $data['harga_barang'] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row justify-content-center">
                            <label class="col-sm-2 col-form-label">Jenis</label>
                            <div class="col-sm-6">
                                <input type="text" name="jenisBarang" class="form-control" value="<?= $data['jenis_barang'] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row justify-content-center">
                            <label class="col-sm-2 col-form-label">Merk</label>
                            <div class="col-sm-6">
                                <input type="text" name="merkBarang" class="form-control" value="<?= $data['merk_barang'] ?>">
                            </div>
                        </div>
                        <div class="mb-3 row justify-content-center">
                            <label class="col-sm-2 col-form-label">Jumlah</label>
                            <div class="col-sm-6">
                                <input type="number" name="jumlahBarang" class="form-control" value="<?= $data['jumlah_barang'] ?>">
                            </div>
                        </div>
                        <?php $cancel = "form/form_sparepart.php"; ?>
                        <?php break;
    }
    ?>

                <!-- Tombol Simpan dan Batal -->
                <div class="mb-3 row justify-content-center text-center">
                    <div class="col-sm-6">
                        <button type="submit" name="aksi" value="edit" class="btn btn-success">
                            <i class="bi bi-floppy-fill me-2"></i>Simpan Perubahan
                        </button>
                        <a href="<?php echo $cancel; ?>" class="btn btn-danger ms-5">
                            <i class="bi bi-arrow-return-left me-2"></i>Batal
                        </a>
                    </div>
                </div>
            </form>
        <?php endif; ?>