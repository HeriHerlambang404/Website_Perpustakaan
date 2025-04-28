<?php
session_start();  // Tambahkan session_start() di bagian atas

// Include file koneksi database
include 'service/database.php'; // Ganti dengan file koneksi database yang sesuai

// Query untuk mengambil buku terbaru
$query = "SELECT * FROM books ORDER BY release_date DESC LIMIT 10";
$result = mysqli_query($db, $query);

// Jika ada request untuk menghapus buku
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM books WHERE id = $delete_id";
    if (mysqli_query($db, $delete_query)) {
        // Set pesan sukses dalam session
        $_SESSION['message'] = "Buku berhasil dihapus!";
    } else {
        $_SESSION['message'] = "Gagal menghapus buku.";
    }
    // Redirect kembali ke halaman daftarbuku.php
    header("Location: daftarbuku.php");
    exit();  // Pastikan script berhenti setelah redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Daftar Buku - Perpustakaan Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"/>
    <script src="https://kit.fontawesome.com/a2e0e6b15a.js" crossorigin="anonymous"></script>
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
            overflow-y: auto;
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
        .btn {
            padding: 10px 20px;
            background-color: #ff5733;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #e14e2a;
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

        /* Modal Styles */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4); 
        }
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 400px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .modal input, .modal select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        /* Alert box */
        .alert {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Daftar Buku Yang Tersedia</h1>

    <?php
    // Menampilkan pesan jika ada dalam session
    if (isset($_SESSION['message'])) {
        echo "<div class='alert'>" . $_SESSION['message'] . "</div>";
        // Menghapus pesan setelah ditampilkan
        unset($_SESSION['message']);
    }
    ?>
    
    <!-- Tombol untuk membuka Modal Tambah Buku -->
    <div style="text-align: center; margin-bottom: 20px;">
        <button class="btn" onclick="openAddBookModal()">Tambah Buku</button>
    </div>
    
    <div class="book-list">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Cek apakah buku sudah dipinjam
                $isBorrowed = $row['is_borrowed'] == 1;

                echo "<div class='book-card'>";
                echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                echo "<p>by " . htmlspecialchars($row['author']) . "</p>";
                echo "<p>Published: " . htmlspecialchars($row['release_date']) . "</p>";

                // Menampilkan tombol Pinjam atau pesan jika sudah dipinjam
                if ($isBorrowed) {
                    echo "<button class='btn' disabled>Buku Sedang Dipinjam</button>";
                } else {
                    echo "<button class='btn' onclick='openModal(" . $row['id'] . ")'>Pinjam</button>";
                }

                // Tombol Edit dan Hapus
                echo "<div style='margin-top: 10px;'>";
                echo "<button class='btn' onclick='openEditBookModal(" . $row['id'] . ", \"" . htmlspecialchars($row['title']) . "\", \"" . htmlspecialchars($row['author']) . "\", \"" . htmlspecialchars($row['release_date']) . "\")'>Edit</button>";
                echo "<a href='?delete_id=" . $row['id'] . "' class='btn' style='background-color: #e14e2a; margin-left: 5px;'>Hapus</a>";
                echo "</div>";

                echo "</div>";
            }
        } else {
            echo "<p>Tidak ada buku yang tersedia</p>";
        }
        ?>
    </div>

    <!-- Back to Dashboard Button -->
    <div class="back-btn">
        <a href="dashboard.php">Kembali ke Dashboard</a>
    </div>
</div>

<!-- Modal untuk Formulir Peminjaman -->
<div id="loanModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Form Peminjaman Buku</h2>
        <form method="POST" action="loan_process.php">
            <input type="hidden" id="book_id" name="book_id" value="">

            <!-- Tambahan input username -->
            <label for="username">Username Peminjam:</label>
            <input type="text" id="username" name="username" required placeholder="Masukkan username peminjam">

            <label for="loan_date">Tanggal Peminjaman:</label>
            <input type="date" id="loan_date" name="loan_date" required>

            <label for="return_date">Tanggal Pengembalian:</label>
            <input type="date" id="return_date" name="return_date" required>

            <button type="submit" class="btn">Ajukan Peminjaman</button>
        </form>
    </div>
</div>

<!-- Modal untuk Formulir Edit Buku -->
<div id="editBookModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditBookModal()">&times;</span>
        <h2>Edit Buku</h2>
        <form method="POST" action="edit_book.php">
            <input type="hidden" id="edit_book_id" name="book_id">

            <label for="edit_title">Judul Buku:</label>
            <input type="text" id="edit_title" name="title" required>

            <label for="edit_author">Pengarang:</label>
            <input type="text" id="edit_author" name="author" required>

            <label for="edit_release_date">Tanggal Rilis:</label>
            <input type="date" id="edit_release_date" name="release_date" required>

            <button type="submit" class="btn">Simpan Perubahan</button>
        </form>
    </div>
</div>

<!-- Modal untuk Formulir Tambah Buku -->
<div id="addBookModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddBookModal()">&times;</span>
        <h2>Tambah Buku</h2>
        <form method="POST" action="add_book.php"> <!-- Ganti action sesuai dengan file proses tambah buku -->
            <label for="title">Judul Buku:</label>
            <input type="text" id="title" name="title" required>

            <label for="author">Pengarang:</label>
            <input type="text" id="author" name="author" required>

            <label for="release_date">Tanggal Rilis:</label>
            <input type="date" id="release_date" name="release_date" required>

            <button type="submit" class="btn">Tambah Buku</button>
        </form>
    </div>
</div>

<script>
    // Function to open the modal for adding a book
    function openAddBookModal() {
        document.getElementById('addBookModal').style.display = 'block';
    }

    // Function to close the add book modal
    function closeAddBookModal() {
        document.getElementById('addBookModal').style.display = 'none';
    }

    // Function to open the modal for loan form
    function openModal(bookId) {
        document.getElementById('book_id').value = bookId;
        document.getElementById('loanModal').style.display = 'block';
    }

    // Function to close the modal for loan form
    function closeModal() {
        document.getElementById('loanModal').style.display = 'none';
    }

    // Function to open the modal for editing a book
    function openEditBookModal(bookId, title, author, release_date) {
        document.getElementById('edit_book_id').value = bookId;
        document.getElementById('edit_title').value = title;
        document.getElementById('edit_author').value = author;
        document.getElementById('edit_release_date').value = release_date;
        document.getElementById('editBookModal').style.display = 'block';
    }

    // Function to close the edit book modal
    function closeEditBookModal() {
        document.getElementById('editBookModal').style.display = 'none';
    }

    // Close modal if user clicks anywhere outside of it
    window.onclick = function(event) {
        if (event.target == document.getElementById('loanModal') || event.target == document.getElementById('addBookModal') || event.target == document.getElementById('editBookModal')) {
            closeModal();
            closeAddBookModal();
            closeEditBookModal();
        }
    }
</script>

</body> 
</html>
