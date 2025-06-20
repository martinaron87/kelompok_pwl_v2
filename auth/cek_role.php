<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function hanyaAdmin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../halaman_utama.php?akses=ditolak");
        exit();
    }
}

function adminAtauTeknisi() {
    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'teknisi'])) {
        header("Location: ../halaman_utama.php?akses=ditolak");
        exit();
    }
}
