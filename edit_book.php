<?php
// Include file koneksi database
include 'service/database.php'; // Ganti dengan file koneksi database yang sesuai

// Cek jika data dikirimkan melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $release_date = $_POST['release_date'];

    // Query untuk mengupdate data buku
    $query = "UPDATE books SET title = ?, author = ?, release_date = ? WHERE id = ?";
    $stmt = mysqli_prepare($db, $query);
    
    // Bind parameter ke query
    mysqli_stmt_bind_param($stmt, 'sssi', $title, $author, $release_date, $book_id);
    
    // Eksekusi query
    if (mysqli_stmt_execute($stmt)) {
        // Jika berhasil, tampilkan pesan sukses
        $message = "Buku berhasil diperbarui!";
    } else {
        // Jika gagal, tampilkan pesan error
        $message = "Gagal memperbarui buku.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Buku - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"/>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            margin: 0;
            padding: 0;
            background-color: #f7fcfc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 600px;
        }
        h1 {
            text-align: center;
            color: #00bcd4;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #00bcd4;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0097a7;
        }
        .message {
            padding: 15px;
            background-color: #f0f0f0;
            border-radius: 8px;
            margin-top: 20px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Buku</h1>

    <!-- Pesan Feedback -->
    <?php if (isset($message)) { ?>
        <div class="message">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <!-- Tombol Kembali ke Dashboard -->
    <form action="daftarbuku.php" method="get">
        <button type="submit" class="btn">Kembali ke Daftarbuku</button>
    </form>
</div>

</body>
</html>
