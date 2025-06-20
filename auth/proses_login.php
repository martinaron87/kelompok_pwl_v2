<?php
session_start();
require '../databases/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_input = mysqli_real_escape_string($conn, $_POST['user_input']);
    $password = $_POST['password'];

    $query = "SELECT * FROM karyawan WHERE id = ? OR email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $user_input, $user_input);
    $stmt->execute();

    error_log("Mencari user_input: " . $user_input);
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        error_log("Data user ditemukan: " . print_r($user, true));

        if (password_verify($password, $user['password'])) {
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['posisi'];
            $_SESSION['user_id'] = $user['id'];

            header('Location: ../halaman_utama.php');
            exit();
        } else {
            $_SESSION['error'] = "Password salah atau akun tidak ditemukan.";
            header('Location: form_login.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Email atau ID tidak ditemukan";
        header('Location: form_login.php');
        exit();
    }
} else {
    header('Location: form_login.php');
    exit();
}
?>
