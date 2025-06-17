<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Aplikasi Konser</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <a href="index.php" class="logo">KonserApp</a>
            <nav class="nav-links">
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="tampil_pembeli.php">Pembeli</a></li>
                    <li><a href="tampil_tiket.php">Tiket</a></li>
                    <li><a href="tampil_laporan.php">Laporan</a></li>
                    <li><a href="login.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <h2>Selamat Datang di Dashboard!</h2>
        <p>Anda bisa mulai mengelola data konser dan tiket di sini.</p>

        <h3>Statistik Penjualan Tiket</h3>
        <div class="agregat-box">
            <?php
            // Query untuk agregasi
            $sql_total_tiket = "SELECT COUNT(tiket_id) AS total_tiket FROM tiket";
            $sql_total_harga = "SELECT SUM(harga) AS total_pendapatan FROM tiket";
            $sql_max_harga = "SELECT MAX(harga) AS tiket_termahal FROM tiket";
            $sql_min_harga = "SELECT MIN(harga) AS tiket_termurah FROM tiket";

            $result_total_tiket = $conn->query($sql_total_tiket);
            $total_tiket = $result_total_tiket->fetch_assoc()['total_tiket'];

            $result_total_harga = $conn->query($sql_total_harga);
            $total_pendapatan = $result_total_harga->fetch_assoc()['total_pendapatan'];

            $result_max_harga = $conn->query($sql_max_harga);
            $tiket_termahal = $result_max_harga->fetch_assoc()['tiket_termahal'];

            $result_min_harga = $conn->query($sql_min_harga);
            $tiket_termurah = $result_min_harga->fetch_assoc()['tiket_termurah'];

            $conn->close(); // Tutup koneksi setelah semua query
            ?>
            <div class="agregat-item">
                <h4>Total Tiket Terjual</h4>
                <p><?php echo number_format($total_tiket, 0, ',', '.'); ?></p>
            </div>
            <div class="agregat-item">
                <h4>Total Pendapatan</h4>
                <p>Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></p>
            </div>
            <div class="agregat-item">
                <h4>Tiket Termahal</h4>
                <p>Rp <?php echo number_format($tiket_termahal, 0, ',', '.'); ?></p>
            </div>
            <div class="agregat-item">
                <h4>Tiket Termurah</h4>
                <p>Rp <?php echo number_format($tiket_termurah, 0, ',', '.'); ?></p>
            </div>
        </div>

        <div class="nav-links" style="text-align: center; margin-top: 50px;">
            <p>Pilih menu untuk mengelola data:</p>
            <ul>
                <li><a href="tambah_tiket.php" class="btn-action">Tambah Tiket Baru</a></li>
                <li><a href="tampil_pembeli.php">Lihat & Kelola Pembeli</a></li>
                <li><a href="tampil_tiket.php">Lihat & Kelola Tiket</a></li>
                <li><a href="tampil_laporan.php">Lihat Laporan Tiket & Pembeli</a></li>
            </ul>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2025 Aplikasi Konser. Hak Cipta Dilindungi.</p>
    </footer>
</body>
</html>