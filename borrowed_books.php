<?php
include 'service/database.php'; // Koneksi database

// Jika tombol "Kembalikan" ditekan
if (isset($_POST['return_book_id'])) {
    $book_id = $_POST['return_book_id'];
    $return_date = date('Y-m-d'); // Tanggal pengembalian = hari ini

    // Mulai transaction
    mysqli_begin_transaction($db);

    try {
        // 1. Simpan dulu riwayat peminjaman ke loan_history
        $history_query = "INSERT INTO loan_history (book_id, loan_date, return_date, borrowed_by) 
                          SELECT id, loan_date, ?, borrowed_by FROM books WHERE id = ?";
        $history_stmt = $db->prepare($history_query);
        $history_stmt->bind_param("si", $return_date, $book_id);
        $history_stmt->execute();

        // 2. Baru update status buku
        $update_query = "UPDATE books SET is_borrowed = 0, borrowed_by = NULL, loan_date = NULL, return_date = NULL WHERE id = ?";
        $update_stmt = $db->prepare($update_query);
        $update_stmt->bind_param("i", $book_id);
        $update_stmt->execute();

        // Commit transaction
        mysqli_commit($db);
        $message = "Buku berhasil dikembalikan!";
    } catch (Exception $e) {
        // Rollback kalau ada error
        mysqli_rollback($db);
        $message = "Terjadi kesalahan saat mengembalikan buku.";
    }
}

// Ambil daftar buku yang sedang dipinjam
$query = "SELECT * FROM books WHERE is_borrowed = 1 AND return_date >= CURDATE()"; 
$result = mysqli_query($db, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Buku yang Sedang Dipinjam - Perpustakaan Digital</title>
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
        }
        h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
            color: #00bcd4;
        }
        .book-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .book-card {
            background: #00bcd4;
            color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .book-card:hover {
            transform: translateY(-5px);
        }
        .book-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .book-card p {
            font-size: 14px;
            margin-bottom: 15px;
        }
        .return-btn {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 10px;
            display: inline-block;
            border: none;
            cursor: pointer;
        }
        .return-btn:hover {
            background-color: #218838;
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
    <h1>Buku yang Sedang Dipinjam</h1>

    <?php
    if (isset($message)) {
        echo "<div style='color: #28a745; text-align: center; margin-bottom: 20px;'>$message</div>";
    }
    ?>
    
    <div class="book-list">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='book-card'>";
                echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                echo "<p>by " . htmlspecialchars($row['author']) . "</p>";
                echo "<p>Dipinjam oleh: " . htmlspecialchars($row['borrowed_by']) . "</p>";
                echo "<p>Dipinjam sejak: " . htmlspecialchars($row['loan_date']) . "</p>";
                echo "<p>Tanggal Pengembalian: " . htmlspecialchars($row['return_date']) . "</p>";
                echo "<form method='POST' action='borrowed_books.php'>";
                echo "<input type='hidden' name='return_book_id' value='" . $row['id'] . "' />";
                echo "<button type='submit' class='return-btn'>Kembalikan</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p style='text-align:center;'>Tidak ada buku yang sedang dipinjam saat ini.</p>";
        }
        ?>
    </div>

    <div class="back-btn">
        <a href="dashboard.php">Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>
