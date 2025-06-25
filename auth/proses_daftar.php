<?php
session_start();
require '../databases/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = trim($_POST['id']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $posisi = trim($_POST['posisi']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($posisi == 'admin' && !preg_match('/^ID\d{3}$/', $id)) {
        die("Format ID Admin harus ID diikuti 3 angka (contoh: ID001)");
    }

    if (empty($id) || empty($username) || empty($email) || empty($posisi) || empty($password)) {
        die("Semua field wajib diisi.");
    }

    if ($password !== $confirm_password) {
        die("Password dan konfirmasi password tidak cocok.");
    }

    // Cek apakah ID sudah digunakan
    $check_id = $conn->prepare("SELECT id FROM karyawan WHERE id = ?");
    $check_id->bind_param("s", $id);
    $check_id->execute();
    $check_id->store_result();

    if ($check_id->num_rows > 0) {
        die("ID sudah terdaftar. Silakan gunakan ID lain.");
    }
    $check_id->close();

    $check_email = $conn->prepare("SELECT id FROM karyawan WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        die("Email sudah terdaftar. Silakan gunakan email lain.");
    }
    $check_email->close();

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO karyawan (id, username, password, posisi, email) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $id, $username, $hashedPassword, $posisi, $email);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Pendaftaran berhasil! Silakan login.";
        header("Location: form_login.php");
        exit();
    } else {
        echo "Pendaftaran gagal: " . $stmt->error;
    }

    $stmt->close();
}
?>
