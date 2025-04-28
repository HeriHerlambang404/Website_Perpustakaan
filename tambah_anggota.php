<?php
session_start();
if (!isset($_SESSION['is_login'])) {
    header("Location: login.php");
    exit();
}

include 'service/database.php'; // Koneksi database

$message = ""; // Untuk menyimpan pesan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    
    // Cek apakah username sudah ada
    $checkQuery = "SELECT * FROM userid WHERE username = '$username'";
    $result = mysqli_query($db, $checkQuery);
    
    if (mysqli_num_rows($result) > 0) {
        $message = "Username sudah terdaftar!";
    } else {
        // Simpan anggota baru ke database tanpa password
        $insertQuery = "INSERT INTO userid (username) VALUES ('$username')";
        if (mysqli_query($db, $insertQuery)) {
            $message = "Anggota berhasil ditambahkan!";
        } else {
            $message = "Terjadi kesalahan saat menambahkan anggota.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Tambah Anggota - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"/>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            margin: 0;
            background: #f7fcfc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            padding: 40px;
        }
        h2 {
            text-align: center;
            color: #00bcd4;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 20px;
        }
        .input-group label {
            font-size: 14px;
            color: #444;
            display: block;
            margin-bottom: 5px;
        }
        .input-group input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }
        .btn {
            width: 100%;
            padding: 14px;
            background-color: #00bcd4;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #008c9e;
        }
        .back-btn {
            width: 100%;
            padding: 12px;
            background-color: #ff5733;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        .back-btn:hover {
            background-color: #cc4626;
        }
        .message {
            text-align: center;
            margin-top: 20px;
            padding: 15px;
            background-color: #f1f1f1;
            border-radius: 8px;
            color: #444;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Tambah Anggota Baru</h2>
    
    <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>
    
    <form action="tambah_anggota.php" method="POST">
        <div class="input-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required placeholder="Masukkan username anggota">
        </div>

        <button type="submit" class="btn">Tambah Anggota</button>
        <a href="dashboard.php">
            <button type="button" class="back-btn">Kembali ke Dashboard</button>
        </a>
    </form>
</div>

</body>
</html>
