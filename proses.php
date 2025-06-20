<?php
include 'databases/koneksi.php';

// -------------------- FUNGSI TAMBAH --------------------
if (isset($_GET['tambah'])) {
    if (isset($_POST['aksi']) && $_POST['aksi'] == 'tambah') {
        switch ($_GET['tambah']) {
            case 'pelanggan':
                $id = $_POST['idPelanggan'];
                $nama = $_POST['namaPelanggan'];
                $jk = $_POST['jenis_kelamin'];
                $telp = $_POST['nomorTelepon'];
                $alamat = $_POST['alamat'];
                $tanggal = $_POST['tanggal'];

                if ($id == '' || $nama == '' || $telp == '' || $alamat == '' || $tanggal == '') {
                    header("Location: form/form_pelanggan.php?status=kosong");
                    exit;
                }

                $cek = mysqli_query($conn, "SELECT id_pelanggan FROM pelanggan WHERE id_pelanggan = '$id'");
                if (mysqli_num_rows($cek) > 0) {
                    header("Location: form/form_pelanggan.php?status=gagal");
                    exit;
                }

                $query = "INSERT INTO pelanggan VALUES('$id', '$nama', '$jk', '$telp', '$alamat', '$tanggal')";
                $sql = mysqli_query($conn, $query);
                header("Location: form/form_pelanggan.php?status=" . ($sql ? "sukses" : "gagal"));
                exit;
                // break;

            case 'servis':
                $id = $_POST['idService'];
                $jenis = $_POST['jenisService'];
                $biaya = $_POST['biayaService'];

                if ($id == '' || $jenis == '' || $biaya == '') {
                    header("Location: form/form_service.php?status=kosong");
                    exit;
                }

                $query = "INSERT INTO service VALUES('$id', '$jenis', '$biaya')";
                $sql = mysqli_query($conn, $query);
                header("Location: form/form_service.php?status=" . ($sql ? "sukses" : "gagal"));
                exit;
                // break;

            case 'sparepart':
                $kode = $_POST['kodeBarang'];
                $nama = $_POST['namaBarang'];
                $harga = $_POST['hargaBarang'];
                $jenis = $_POST['jenisBarang'];
                $merk = $_POST['merkBarang'];
                $jumlah = $_POST['jumlahBarang'];

                if ($kode == '' || $nama == '' || $harga == '' || $jenis == '' || $merk == '' || $jumlah == '') {
                    header("Location: form/form_sparepart.php?status=kosong");
                    exit;
                }

                $query = "INSERT INTO sparepart VALUES('$kode', '$nama', '$harga', '$jenis', '$merk', '$jumlah')";
                $sql = mysqli_query($conn, $query);
                header("Location: form/form_sparepart.php?status=" . ($sql ? "sukses" : "gagal"));
                exit;
                // break;

                case 'transaksi':
                    $id = $_POST['id_transaksi'];
                    $id_pelanggan = $_POST['id_pelanggan'];
                    $id_service = $_POST['id_service'];
                    $tanggal_masuk = $_POST['tanggal_masuk'];
                    $kerusakan = $_POST['kerusakan'];
                    $spareparts = $_POST['sparepart'];
                    $jumlah = $_POST['jumlah'];

                    $total_biaya = 0;

                    $q1 = mysqli_query($conn, "SELECT biaya_service FROM service WHERE id_service = '$id_service'");
                    if ($d1 = mysqli_fetch_assoc($q1)) {
                        $total_biaya += (int)$d1['biaya_service'];
                    }

                    $query = "INSERT INTO transaksi 
                        (id_transaksi, id_pelanggan, id_service, tanggal_masuk, kerusakan, total_biaya)
                        VALUES ('$id', '$id_pelanggan', '$id_service', '$tanggal_masuk', '$kerusakan', '$total_biaya')";
                    $sql = mysqli_query($conn, $query);

                    if ($sql) {
                        for ($i = 0; $i < count($spareparts); $i++) {
                            $kode = $spareparts[$i];
                            $qty = (int)$jumlah[$i];

                            $q2 = mysqli_query($conn, "SELECT harga_barang FROM sparepart WHERE kd_barang = '$kode'");
                            if ($d2 = mysqli_fetch_assoc($q2)) {
                                $subtotal = (int)$d2['harga_barang'] * $qty;
                                $total_biaya += $subtotal;
                            }

                            mysqli_query($conn, "INSERT INTO transaksi_sparepart (id_transaksi_sparepart, kd_barang, jumlah) VALUES ('$id', '$kode', '$qty')");
                        }

                        mysqli_query($conn, "UPDATE transaksi SET total_biaya = '$total_biaya' WHERE id_transaksi = '$id'");
                    }

                    header("Location: form/form_transaksi.php?status=" . ($sql ? "sukses" : "gagal"));
                    exit;
                // break;
        }
    }
}

// -------------------- FUNGSI EDIT --------------------
if (isset($_GET['formUbah'])) {
    if (isset($_POST['aksi']) && $_POST['aksi'] == 'edit') {
        switch ($_GET['formUbah']) {
            case 'pelanggan':
                $id = $_POST['idPelanggan'];
                $nama = $_POST['namaPelanggan'];
                $jk = $_POST['jenis_kelamin'];
                $telp = $_POST['nomorTelepon'];
                $alamat = $_POST['alamat'];
                $tanggal = $_POST['tanggal'];

                $query = "UPDATE pelanggan SET 
                    nama_pelanggan = '$nama', 
                    jenis_kelamin = '$jk', 
                    nomor_telepon = '$telp', 
                    alamat = '$alamat', 
                    tanggal = '$tanggal' 
                    WHERE id_pelanggan = '$id'";
                $sql = mysqli_query($conn, $query);
                header("Location: form/form_pelanggan.php?status=" . ($sql ? "ubah" : "gagal"));
                exit;
                // break;

            case 'servis':
                $id = $_POST['idService'];
                $jenis = $_POST['jenisService'];
                $biaya = $_POST['biayaService'];

                $query = "UPDATE service SET 
                    jenis_service = '$jenis', 
                    biaya_service = '$biaya' 
                    WHERE id_service = '$id'";
                $sql = mysqli_query($conn, $query);
                header("Location: form/form_service.php?status=" . ($sql ? "ubah" : "gagal"));
                exit;
                // break;

            case 'sparepart':
                $kode = $_POST['kodeBarang'];
                $nama = $_POST['namaBarang'];
                $harga = $_POST['hargaBarang'];
                $jenis = $_POST['jenisBarang'];
                $merk = $_POST['merkBarang'];
                $jumlah = $_POST['jumlahBarang'];

                $query = "UPDATE sparepart SET 
                    nama_barang = '$nama', 
                    harga_barang = '$harga', 
                    jenis_barang = '$jenis', 
                    merk_barang = '$merk', 
                    jumlah_barang = '$jumlah' 
                    WHERE kd_barang = '$kode'";
                $sql = mysqli_query($conn, $query);
                header("Location: form/form_sparepart.php?status=" . ($sql ? "ubah" : "gagal"));
                exit;
                // break;
        }
    }
}

// -------------------- FUNGSI HAPUS --------------------
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $query = "DELETE FROM pelanggan WHERE id_pelanggan = '$id'";
    $sql = mysqli_query($conn, $query);
    header("Location: form/form_pelanggan.php?status=" . ($sql ? "hapus" : "gagal"));
    exit;
}

if (isset($_GET['hapusService'])) {
    $id = $_GET['hapusService'];
    $query = "DELETE FROM service WHERE id_service = '$id'";
    $sql = mysqli_query($conn, $query);
    header("Location: form/form_service.php?status=" . ($sql ? "hapus" : "gagal"));
    exit;
}

if (isset($_GET['hapusSparepart'])) {
    $id = $_GET['hapusSparepart'];
    $query = "DELETE FROM sparepart WHERE kd_barang = '$id'";
    $sql = mysqli_query($conn, $query);
    header("Location: form/form_sparepart.php?status=" . ($sql ? "hapus" : "gagal"));
    exit;
}

if (isset($_GET['hapusTransaksi'])) {
    $id = $_GET['hapusTransaksi'];
    mysqli_query($conn, "DELETE FROM transaksi_sparepart WHERE id_transaksi_sparepart = '$id'");
    $query = "DELETE FROM transaksi WHERE id_transaksi = '$id'";
    $sql = mysqli_query($conn, $query);
     header("Location: form/form_transaksi.php?status=" . ($sql ? "hapus" : "gagal"));
    exit;
}
?>
