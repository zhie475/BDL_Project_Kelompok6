<?php
include 'koneksi.php';

$message = '';
$tiket_data = []; // Untuk menyimpan data tiket yang akan diedit

if (isset($_GET['id'])) {
    $tiket_id = $_GET['id'];

    // Ambil data tiket yang akan diedit
    $stmt = $conn->prepare("SELECT tiket_id, pembeli_id, nama_konser, kategori, harga, tgl_pembelian FROM tiket WHERE tiket_id = ?");
    $stmt->bind_param("i", $tiket_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $tiket_data = $result->fetch_assoc();
    } else {
        $message = "<div class='message error'>Tiket tidak ditemukan.</div>";
        // Redirect jika tiket tidak ditemukan
        header("Location: tampil_tiket.php");
        exit();
    }
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tiket_id = $_POST['tiket_id'];
    $pembeli_id = $_POST['pembeli_id'];
    $nama_konser = $_POST['nama_konser'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $tgl_pembelian = $_POST['tgl_pembelian'];

    $stmt = $conn->prepare("UPDATE tiket SET pembeli_id = ?, nama_konser = ?, kategori = ?, harga = ?, tgl_pembelian = ? WHERE tiket_id = ?");
    $stmt->bind_param("isssdi", $pembeli_id, $nama_konser, $kategori, $harga, $tgl_pembelian, $tiket_id);

    
    if ($stmt->execute()) {
        $message = "<div class='message success'>Tiket berhasil diperbarui!</div>";
        // Perbarui data tiket_data agar form menampilkan data terbaru
        $tiket_data = [
            'tiket_id' => $tiket_id,
            'pembeli_id' => $pembeli_id,
            'nama_konser' => $nama_konser,
            'kategori' => $kategori,
            'harga' => $harga,
            'tgl_pembelian' => $tgl_pembelian
        ];
    } else {
        $message = "<div class='message error'>Error: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// Ambil daftar pembeli untuk dropdown (diperlukan setiap kali halaman dimuat)
$pembeli_query = "SELECT pembeli_id, nama FROM pembeli ORDER BY nama";
$pembeli_result = $conn->query($pembeli_query);
$pembeli_options = '';
if ($pembeli_result->num_rows > 0) {
    while($row = $pembeli_result->fetch_assoc()) {
        $selected = ($row['pembeli_id'] == $tiket_data['pembeli_id']) ? 'selected' : '';
        $pembeli_options .= "<option value='" . $row['pembeli_id'] . "' " . $selected . ">" . $row['nama'] . " (ID: " . $row['pembeli_id'] . ")</option>";
    }
} else {
    $pembeli_options = "<option value=''>Tidak ada pembeli. Tambah pembeli dulu!</option>";
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tiket | Aplikasi Konser</title>
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
            <h2>Edit Tiket</h2>
            <?php echo $message; ?>
            <form action="edit_tiket.php" method="POST">
                <input type="hidden" name="tiket_id" value="<?php echo htmlspecialchars($tiket_data['tiket_id'] ?? ''); ?>">
                <div class="form-group">
                    <label for="pembeli_id">Pembeli:</label>
                    <select id="pembeli_id" name="pembeli_id" required>
                        <option value="">-- Pilih Pembeli --</option>
                        <?php echo $pembeli_options; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nama_konser">Nama Konser:</label>
                    <input type="text" id="nama_konser" name="nama_konser" value="<?php echo htmlspecialchars($tiket_data['nama_konser'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori:</label>
                    <select id="kategori" name="kategori" required>
                        <option value="VIP" <?php echo (isset($tiket_data['kategori']) && $tiket_data['kategori'] == 'VIP') ? 'selected' : ''; ?>>VIP</option>
                        <option value="Reguler" <?php echo (isset($tiket_data['kategori']) && $tiket_data['kategori'] == 'Reguler') ? 'selected' : ''; ?>>Reguler</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="harga">Harga:</label>
                    <input type="number" id="harga" name="harga" value="<?php echo htmlspecialchars($tiket_data['harga'] ?? ''); ?>" required min="0">
                </div>
                <div class="form-group">
                    <label for="tgl_pembelian">Tanggal Pembelian:</label>
                    <input type="date" id="tgl_pembelian" name="tgl_pembelian" value="<?php echo htmlspecialchars($tiket_data['tgl_pembelian'] ?? ''); ?>" required>
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn-primary">Update Tiket</button>
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