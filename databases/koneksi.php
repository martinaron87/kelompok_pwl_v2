<?php
// konfigurasi database
$host     = 'localhost';
$user     = 'root';
$password = '';
$database = 'db_service_gadget_pwl';

// membuat koneksi
$conn = mysqli_connect($host, $user, $password, $database);

// cek koneksi
if (!$conn) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}

// set charset agar mendukung karakter UTF-8
mysqli_set_charset($conn, 'utf8');
?>
