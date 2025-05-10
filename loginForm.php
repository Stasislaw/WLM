
<!-- File: loginForm.php -->
<?php
require_once('auth.php');
require_once('header.php');
checkRememberMeCookie($pdo);

if (isset($_SESSION['user_id'])){
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Zaloguj się</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="login-container">
    <form action="./login.php" method="post">
      <h2>Zaloguj się</h2>
      <label for="username">Nazwa użytkownika:</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Hasło:</label>
      <input type="password" id="password" name="password" required>

      <div class="remember-row">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Zapamiętaj mnie</label>
      </div>

      <button type="submit">Zaloguj</button>
      <p class="register-link"><a href="./registerForm.php">Utwórz konto</a></p>
    </form>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<p class='error'>" . htmlspecialchars($_SESSION['error']) . "</p>";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])){
        echo "<p class='success'>" . htmlspecialchars($_SESSION['success']) . "</p>";
        unset($_SESSION['success']);
    }
    ?>
  </div>

</body>
</html>