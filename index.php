<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Beranda - Perpustakaan Digital</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet"/>
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
    .nav-buttons a {
      margin-left: 20px;
      text-decoration: none;
      color: #00bcd4;
      font-weight: bold;
      padding: 10px 20px;
      border: 2px solid #00bcd4;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    .nav-buttons a:hover {
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
    .hero-text {
      background-color: rgba(255, 255, 255, 0.9);
      padding: 40px 30px;
      border-radius: 15px;
      max-width: 700px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    .hero-text h1 {
      font-size: 2.5rem;
      color: #333;
      margin-bottom: 10px;
    }
    .hero-text p {
      font-size: 1.1rem;
      color: #555;
    }
    @media (max-width: 600px) {
      .hero-text h1 {
        font-size: 1.8rem;
      }
      .hero-text p {
        font-size: 1rem;
      }
      header {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">Perpustakaan Digital</div>
    <div class="nav-buttons">
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
    </div>
  </header>

  <main>
    <div class="hero-text">
      <h1>Selamat Datang di Perpustakaan Digital</h1>
      <p>Temukan dan baca berbagai koleksi buku digital dengan mudah, cepat, dan gratis. Ayo login atau daftar sekarang untuk mulai menjelajah!</p>
    </div>
  </main>
</body>
</html>
