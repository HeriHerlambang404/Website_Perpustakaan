<?php
session_start();
if (!isset($_SESSION['is_login'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Beranda - Perpustakaan Digital</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"/>
  <script src="https://kit.fontawesome.com/a2e0e6b15a.js" crossorigin="anonymous"></script> <!-- Font Awesome untuk icon -->
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }
    body {
      margin: 0;
      padding: 0;
      background: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f') no-repeat center center/cover;
      min-height: 100vh;
      position: relative;
    }
    body::before {
      content: '';
      position: absolute;
      inset: 0;
      background-color: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(2px);
      z-index: -1;
    }
    header {
      width: 100%;
      padding: 20px 50px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: rgba(255, 255, 255, 0.9);
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      position: relative;
      z-index: 1;
    }
    .logo {
      font-weight: bold;
      color: #00bcd4;
      font-size: 24px;
    }
    .nav-buttons-header {
      display: flex;
      gap: 10px;
    }
    .nav-buttons-header form {
      display: inline-block;
    }
    .nav-buttons-header a, .nav-buttons-header button {
      text-decoration: none;
      color: #00bcd4;
      font-weight: bold;
      padding: 10px 20px;
      border: 2px solid #00bcd4;
      border-radius: 8px;
      transition: all 0.3s ease;
      background: none;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
      width: auto; /* Pastikan tombol tidak terlalu besar atau kecil */
      height: 40px; /* Ukuran tinggi tombol yang seragam */
    }
    .nav-buttons-header a:hover, .nav-buttons-header button:hover {
      background-color: #00bcd4;
      color: #fff;
    }

    main {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 60px 20px;
      text-align: center;
      z-index: 1;
      position: relative;
    }
    .menu-section {
      display: grid;
      grid-template-columns: repeat(4, 1fr); /* 4 kolom rapi */
      gap: 20px;
      width: 100%;
      max-width: 1000px;
      background-color: rgba(255, 255, 255, 0.9);
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    .menu-card {
      background: #fff;
      border: 2px solid #00bcd4;
      border-radius: 12px;
      padding: 30px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      color: #00bcd4;
      transition: all 0.3s ease;
    }
    .menu-card:hover {
      background-color: #00bcd4;
      color: #fff;
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 188, 212, 0.4);
    }
    .menu-card i {
      font-size: 40px;
      margin-bottom: 15px;
    }
    .menu-card h3 {
      margin: 10px 0 5px;
      font-size: 1.3rem;
    }
    .menu-card p {
      font-size: 0.9rem;
      color: #555;
      margin: 0;
    }
    .menu-card:hover p {
      color: #fff;
    }
    @media (max-width: 900px) {
      .menu-section {
        grid-template-columns: repeat(2, 1fr); /* tablet, 2 kolom */
      }
    }
    @media (max-width: 600px) {
      .menu-section {
        grid-template-columns: 1fr; /* hp kecil, 1 kolom */
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">Perpustakaan Digital</div>
    <div class="nav-buttons-header">
      <a href="index.php" class="home-btn">Home</a>
      <form method="POST">
        <button type="submit" name="logout">Logout</button>
      </form>
    </div>
  </header>

  <main>
    <div class="menu-section">
      <a href="tambah_anggota.php" class="menu-card">
        <i class="fas fa-user-plus"></i>
        <h3>Tambah Anggota</h3>
        <p>Registrasi anggota baru ke dalam sistem.</p>
      </a>
      <a href="daftarbuku.php" class="menu-card">
        <i class="fas fa-book"></i>
        <h3>Daftar Buku</h3>
        <p>Lihat semua koleksi buku yang tersedia.</p>
      </a>
      <a href="borrowed_books.php" class="menu-card">
        <i class="fas fa-book-reader"></i>
        <h3>Buku Dipinjam</h3>
        <p>Data buku yang sedang dipinjam.</p>
      </a>
      <a href="riwayat_peminjaman.php" class="menu-card">
        <i class="fas fa-history"></i>
        <h3>Riwayat Peminjaman</h3>
        <p>Cek catatan peminjaman sebelumnya.</p>
      </a>
    </div>
  </main>
</body>
</html>
