
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
                    <li><a href="login.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
<?php include 'koneksi.php';

// Ambil data pembelian
$query = "SELECT tiket_id, pembeli_id, nama_konser, kategori, harga, tgl_pembelian FROM tiket";
$result = mysqli_query($conn, $query);

// Hitung total pendapatan
$total_query = "SELECT SUM(harga) AS total_pendapatan FROM tiket";
$total_result = mysqli_query($conn, $total_query);
$total = mysqli_fetch_assoc($total_result)['total_pendapatan'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembelian Tiket</title>
</head>
<body>

<h2 align="center">Laporan Pembelian Tiket</h2>

<table border="1" width="100%" cellpadding="5" cellspacing="0" align="center">
    <tr>
        <th>No</th>
        <th>ID TIKET</th>
        <th>ID PEMBELI</th>
        <th>NAMA KONSER</th>
        <th>KATEGORI</th>
        <th>HARGA</th>
        <th>TANGGAL PEMBELIAN</th>
    </tr>

    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>$no</td>
                <td>{$row['tiket_id']}</td>
                <td>{$row['pembeli_id']}</td>
                <td>{$row['nama_konser']}</td>
                <td>{$row['kategori']}</td>
                <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                <td>{$row['tgl_pembelian']}</td>
              </tr>";
        $no++;
    }
    ?>

    <tr>
        <td colspan="4" align="right"><strong>Total Pendapatan</strong></td>
        <td colspan="3"><strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></td>
    </tr>
</table>
</body>
</html>