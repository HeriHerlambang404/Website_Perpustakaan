<?php
include "service/database.php";
session_start();

$login_message = "";

if (isset($_SESSION['is_login'])) {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM userid WHERE username='$username' AND password='$password'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $_SESSION['username'] = $data['username'];
        $_SESSION['is_login'] = true;

        header("Location: dashboard.php");
        exit();
    } else {
        $login_message = "Username atau password Anda salah";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Perpustakaan Digital</title>
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
      <h2>Login</h2>
      <form action="login.php" method="POST">
        <div class="input-group">
          <input type="text" name="username" placeholder="username" required />
        </div>
        <div class="input-group">
          <input type="password" name="password" placeholder="Password" required />
        </div>
        <div class="remember">
          <input type="checkbox" name="remember" />
          <label>Remember me</label>
        </div>
        <button class="btn" type="submit" name="login">Login</button>

        <?php if (isset($login_message) && $login_message): ?>
          <div class="message"><?= htmlspecialchars($login_message) ?></div>
        <?php endif; ?>
      </form>
      <div class="socials">
        <p>Belum punya akun? <a href="register.php">Daftar sekarang</a></p>
      </div>
    </div>
  </div>
</body>
</html>
