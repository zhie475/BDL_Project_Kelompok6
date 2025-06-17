<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $tiket_id = $_GET['id'];

    // Menggunakan prepared statement untuk menghindari SQL injection
    $stmt = $conn->prepare("DELETE FROM tiket WHERE tiket_id = ?");
    $stmt->bind_param("i", $tiket_id);

    if ($stmt->execute()) {
        // Redirect kembali ke halaman tampil_tiket.php dengan pesan sukses
        header("Location: tampil_tiket.php?status=success_delete");
        exit();
    } else {
        // Redirect dengan pesan error jika gagal
        header("Location: tampil_tiket.php?status=error_delete&message=" . urlencode($stmt->error));
        exit();
    }
    $stmt->close();
} else {
    // Redirect jika ID tidak disediakan
    header("Location: tampil_tiket.php?status=error_no_id");
    exit();
}
?>