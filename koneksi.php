<?php
$servername = "localhost";
$username = "root"; // Sesuaikan dengan username database Anda
$password = "";     // Sesuaikan dengan password database Anda
$dbname = "konser"; // Nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);


// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
// echo "Koneksi berhasil"; // Uncomment for testing connection
?>