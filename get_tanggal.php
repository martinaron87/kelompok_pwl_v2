<?php
include 'databases/koneksi.php';

if (isset($_GET['id_pelanggan'])) {
    $id = $_GET['id_pelanggan'];
    $query = mysqli_query($conn, "SELECT tanggal FROM pelanggan WHERE id_pelanggan = '$id'");
    
    if ($data = mysqli_fetch_assoc($query)) {
        echo json_encode([
            'success' => true,
            'tanggal_masuk' => substr($data['tanggal'],0 , 10)
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
