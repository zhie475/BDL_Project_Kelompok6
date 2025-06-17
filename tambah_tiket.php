<?php
include 'koneksi.php';

$message = '';

// Ambil daftar pembeli untuk dropdown
$pembeli_query = "SELECT pembeli_id, nama FROM pembeli ORDER BY nama";
$pembeli_result = $conn->query($pembeli_query);
$pembeli_options = '';
if ($pembeli_result->num_rows > 0) {
    while($row = $pembeli_result->fetch_assoc()) {
        $pembeli_options .= "<option value='" . $row['pembeli_id'] . "'>" . $row['nama'] . " (ID: " . $row['pembeli_id'] . ")</option>";
    }
} else {
    $pembeli_options = "<option value=''>Tidak ada pembeli. Tambah pembeli dulu!</option>";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pembeli_id = $_POST['pembeli_id'];
    $nama_konser = $_POST['nama_konser'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $tgl_pembelian = $_POST['tgl_pembelian'];

    // Menggunakan stored procedure 'tambah_tiket'
    $stmt = $conn->prepare("CALL tambah_tiket(?, ?, ?, ?, ?)");
    $stmt->bind_param("isssd", $pembeli_id, $nama_konser, $kategori, $harga, $tgl_pembelian);

    if ($stmt->execute()) {
        $message = "<div class='message success'>Tiket berhasil ditambahkan!</div>";
    } else {
        $message = "<div class='message error'>Error: " . $stmt->error . "</div>";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial=" initial-scale="1.0">
    <title>Tambah Tiket Baru | Aplikasi Konser</title>
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
                    <li><a href="login.php">Logout (Contoh)</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="form-card">
            <h2>Tambah Tiket Baru</h2>
            <?php echo $message; ?>
            <form action="tambah_tiket.php" method="POST">
                <div class="form-group">
                    <label for="pembeli_id">Pembeli:</label>
                    <select id="pembeli_id" name="pembeli_id" required>
                        <option value="">-- Pilih Pembeli --</option>
                        <?php echo $pembeli_options; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nama_konser">Nama Konser:</label>
                    <input type="text" id="nama_konser" name="nama_konser" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori:</label>
                    <select id="kategori" name="kategori" required>
                        <option value="VIP">VIP</option>
                        <option value="Reguler">Reguler</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="harga">Harga:</label>
                    <input type="number" id="harga" name="harga" required min="0">
                </div>
                <div class="form-group">
                    <label for="tgl_pembelian">Tanggal Pembelian:</label>
                    <input type="date" id="tgl_pembelian" name="tgl_pembelian" required>
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn-primary">Tambah Tiket</button>
                    <a href="tampil_tiket.php" class="btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2025 Aplikasi Konser. Hak Cipta Dilindungi.</p>
    </footer>
</body>
</html>
