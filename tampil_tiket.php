<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Tiket | Aplikasi Konser</title>
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
        <h2>Data Tiket</h2>
        <a href="tambah_tiket.php" class="btn-action">Tambah Tiket Baru</a>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID Tiket</th>
                        <th>ID Pembeli</th>
                        <th>Nama Konser</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Tanggal Pembelian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT tiket_id, pembeli_id, nama_konser, kategori, harga, tgl_pembelian FROM tiket";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["tiket_id"] . "</td>";
                            echo "<td>" . $row["pembeli_id"] . "</td>";
                            echo "<td>" . $row["nama_konser"] . "</td>";
                            echo "<td>" . $row["kategori"] . "</td>";
                            echo "<td>Rp " . number_format($row["harga"], 0, ',', '.') . "</td>";
                            echo "<td>" . $row["tgl_pembelian"] . "</td>";
                            echo "<td>";
                            echo "<a href='edit_tiket.php?id=" . $row['tiket_id'] . "' class='btn-edit'>Edit</a> ";
                            echo "<a href='delete_tiket.php?id=" . $row['tiket_id'] . "' class='btn-danger' onclick=\"return confirm('Yakin ingin menghapus tiket ini? Tindakan ini akan dicatat dalam log!');\">Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Tidak ada data tiket.</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2025 Aplikasi Konser. Hak Cipta Dilindungi.</p>
    </footer>
</body>
</html>