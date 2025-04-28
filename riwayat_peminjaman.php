<?php
include 'service/database.php'; // koneksi database

// Hapus histori kalau ada request hapus
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_query = "DELETE FROM loan_history WHERE id = ?";
    $stmt = $db->prepare($delete_query);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        $message = "Riwayat berhasil dihapus.";
    } else {
        $message = "Gagal menghapus riwayat.";
    }
}

// Ambil seluruh histori peminjaman
$query = "SELECT lh.*, b.title, b.author 
          FROM loan_history lh
          JOIN books b ON lh.book_id = b.id
          ORDER BY lh.created_at DESC";
$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Riwayat Peminjaman Buku - Perpustakaan Digital</title>
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
            padding: 20px;
        }
        .container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 1200px;
            overflow: hidden;
            padding: 40px;
        }
        h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
            color: #00bcd4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #00bcd4;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .delete-btn {
            background-color: #e74c3c;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .delete-btn:hover {
            background-color: #c0392b;
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
    <h1>Riwayat Peminjaman Buku</h1>

    <?php
    if (isset($message)) {
        echo "<div style='color: #28a745; text-align: center; margin-bottom: 20px;'>$message</div>";
    }
    ?>

    <table>
        <thead>
            <tr>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Dipinjam Oleh</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal pengembalian</th>
                <th>Detail Tanggal Pengembalian</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['author']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['borrowed_by']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['loan_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['return_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Belum ada riwayat peminjaman.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="back-btn">
        <a href="dashboard.php">Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>
