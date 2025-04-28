<?php
// Include file koneksi database
include 'service/database.php'; // Pastikan ini sesuai dengan lokasi file koneksi Anda

// Variabel status untuk menampilkan pesan
$message = "";
$success = false;

// Cek apakah form sudah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $author = mysqli_real_escape_string($db, $_POST['author']);
    $release_date = mysqli_real_escape_string($db, $_POST['release_date']);

    // Query untuk menambahkan buku ke database
    $query = "INSERT INTO books (title, author, release_date, is_borrowed, loan_date, return_date) 
              VALUES ('$title', '$author', '$release_date', 0, NULL, NULL)";

    // Mengeksekusi query
    if (mysqli_query($db, $query)) {
        $message = "Buku berhasil ditambahkan!";
        $success = true;
    } else {
        $message = "Gagal menambahkan buku. Coba lagi.";
        $success = false;
    }
} else {
    // Jika form belum disubmit, redirect kembali ke halaman daftar buku
    header("Location: daftarbuku.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Status Tambah Buku - Perpustakaan Digital</title>
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
            overflow-y: auto;
            padding: 0 20px;
        }
        .container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            overflow: hidden;
            padding: 40px;
            text-align: center;
        }
        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #00bcd4;
        }
        .message {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .message.success {
            color: green;
        }
        .message.error {
            color: red;
        }
        .btn {
            padding: 10px 20px;
            background-color: #00bcd4;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0097a7;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Status Tambah Buku</h1>
    <div class="message <?php echo $success ? 'success' : 'error'; ?>">
        <?php echo $message; ?>
    </div>
    <a href="daftarbuku.php" class="btn">Kembali ke Daftar Buku</a>
</div>

</body>
</html>
