<?php
include 'service/database.php'; // Ganti dengan file koneksi database yang sesuai

// Pastikan data yang diterima valid
if (isset($_POST['book_id'], $_POST['loan_date'], $_POST['return_date'], $_POST['username'])) {
    $book_id = $_POST['book_id'];
    $loan_date = $_POST['loan_date'];
    $return_date = $_POST['return_date'];
    $username = $_POST['username'];

    // Cek apakah username ada di database
    $user_check_query = "SELECT * FROM userid WHERE username = ?";
    $stmt = $db->prepare($user_check_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user_result = $stmt->get_result();

    if ($user_result->num_rows == 0) {
        // Jika username tidak ditemukan
        $message = "Username yang anda masukkan tidak ada dalam sistem.";
    } else {
        // Cek apakah buku sudah dipinjam dan belum melewati tenggat waktu
        $check_query = "SELECT * FROM books WHERE id = ? AND is_borrowed = 1 AND return_date >= CURDATE()";
        $stmt = $db->prepare($check_query);
        $stmt->bind_param("i", $book_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Jika buku sudah dipinjam dan belum melewati tenggat waktu
            $message = "Buku ini sudah dipinjam dan belum bisa dipinjam lagi.";
        } else {
            // Jika buku belum dipinjam atau sudah dikembalikan
            $update_query = "UPDATE books SET is_borrowed = 1, loan_date = ?, return_date = ?, borrowed_by = ? WHERE id = ?";
            $stmt = $db->prepare($update_query);
            $stmt->bind_param("sssi", $loan_date, $return_date, $username, $book_id);

            if ($stmt->execute()) {
                $message = "Peminjaman buku berhasil!";
            } else {
                $message = "Terjadi kesalahan saat memproses peminjaman.";
            }
        }
    }
} else {
    $message = "Data peminjaman tidak lengkap. Pastikan Anda mengisi semua kolom.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Proses Peminjaman Buku - Perpustakaan Digital</title>
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
            align-items: flex-start;
            min-height: 100vh;
            padding: 0 20px;
        }
        .container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1000px;
            overflow: hidden;
            padding: 40px;
            text-align: center;
        }
        h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
            color: #00bcd4;
        }
        .message {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
        .message.success {
            color: #28a745;
        }
        .message.error {
            color: #dc3545;
        }
        .back-btn {
            display: block;
            text-align: center;
            margin-top: 30px;
        }
        .back-btn a {
            padding: 12px 20px;
            background-color: #00bcd4;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .back-btn a:hover {
            background-color: #0097a7;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Proses Peminjaman Buku</h1>

    <!-- Pesan status peminjaman -->
    <?php if (isset($message)): ?>
        <div class="message <?php echo (strpos($message, 'berhasil') !== false) ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <!-- Tombol kembali ke halaman dashboard -->
    <div class="back-btn">
        <a href="dashboard.php">Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>
