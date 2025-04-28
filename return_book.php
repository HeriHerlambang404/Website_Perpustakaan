<?php
include 'service/database.php'; // Include koneksi database

// Ambil ID buku
$book_id = $_GET['book_id']; // ID buku yang ingin dikembalikan

// Update status buku kembali tersedia
$query = "UPDATE books SET is_borrowed = 0, loan_date = NULL, return_date = NULL WHERE id = $book_id";
if (mysqli_query($db, $query)) {
    echo "Buku berhasil dikembalikan!";
} else {
    echo "Terjadi kesalahan: " . mysqli_error($db);
}
?>
