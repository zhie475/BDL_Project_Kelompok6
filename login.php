<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Aplikasi Konser</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form-card">
        <h2>Login Aplikasi Konser</h2>
        <form action="dashboard.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-primary">Login</button>
            <p style="margin-top: 15px; font-size: 0.9em; color: #666;">
                Ini adalah contoh tampilan login. <br>Fungsi login sesungguhnya memerlukan validasi database.
            </p>
        </form>
    </div>
</body>
</html>