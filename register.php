<?php
include "service/database.php";
session_start();

$register_message = "";

if (isset($_SESSION['is_login'])) {
    header("location: dashboard.php");
    exit();
}

if (isset($_POST["register"])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (preg_match('/\s/', $username)) {
        $register_message = "Username tidak boleh mengandung spasi.";
    } else {
        $check = $db->query("SELECT * FROM userid WHERE username = '$username'");
        if ($check->num_rows > 0) {
            $register_message = "Username sudah digunakan, coba yang lain.";
        } else {
            $sql = "INSERT INTO userid (username, password) VALUES('$username', '$password')";
            if ($db->query($sql)) {
                $register_message = "Daftar berhasil! Silakan <a href='login.php'>login sekarang</a>.";
            } else {
                $register_message = "Daftar gagal, coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar - Perpustakaan Digital</title>
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
      height: 100vh;
    }
    .container {
      display: flex;
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      width: 90%;
      max-width: 1000px;
    }
    .left {
      flex: 1;
      background: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f') no-repeat center;

      background-size: cover;
      padding: 40px;
    }
    .right {
      flex: 1;
      padding: 50px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .right h2 {
      margin-bottom: 10px;
    }
    .message {
      color: red;
      margin-top: 10px;
      text-align: center;
    }
    .input-group {
      margin-bottom: 20px;
    }
    .input-group input {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    .remember {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }
    .remember input {
      margin-right: 10px;
    }
    .btn {
      padding: 12px;
      width: 100%;
      background-color: #00bcd4;
      border: none;
      color: #fff;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
    }
    .socials {
      margin-top: 20px;
      text-align: center;
    }
    .socials a {
      color: #00bcd4;
      text-decoration: none;
      font-weight: bold;
    }
    .socials a:hover {
      text-decoration: underline;
    }
    .top-nav {
      position: absolute;
      top: 20px;
      right: 50px;
      display: flex;
      gap: 30px;
      font-size: 14px;
    }
    .top-nav a {
      color: #444;
      text-decoration: none;
    }
    .logo {
      position: absolute;
      top: 20px;
      left: 50px;
      font-weight: bold;
      color: #00bcd4;
    }
  </style>

  <!-- ✅ JavaScript untuk blok spasi -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const usernameInput = document.querySelector('input[name="username"]');
      usernameInput.addEventListener("keypress", function(e) {
        if (e.key === " ") {
          e.preventDefault();
        }
      });
    });
  </script>
</head>
<body>
  <div class="logo">Perpustakaan Digital</div>
  <div class="top-nav">
    <a href="#">About</a>
    <a href="#">Contact us</a>
  </div>

  <div class="container">
    <div class="left"></div>
    <div class="right">
      <h2>Daftar Akun</h2>
      <?php if ($register_message): ?>
        <div class="message"><?= $register_message ?></div>
      <?php endif; ?>
      <form action="register.php" method="POST">
        <div class="input-group">
          <input type="text" name="username" placeholder="Username" required />
        </div>
        <div class="input-group">
          <input type="password" name="password" placeholder="Password" required />
        </div>
        <button class="btn" type="submit" name="register">Daftar Sekarang</button>
      </form>
      <div class="socials">
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
      </div>
    </div>
  </div>
</body>
</html>
