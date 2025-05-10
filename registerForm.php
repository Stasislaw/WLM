<!-- File: registerForm.php -->
<?php
require_once('header.php');
require_once('connect.php');
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utwórz konto</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <form action="register.php" method="post">
            <h2>Utwórz konto</h2>

            <label for="username">Nazwa użytkownika:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Hasło:</label>
            <input type="password" id="password" name="password" required>

            <label for="klasa">Klasa:</label>
            <input type="text" id="klasa" name="klasa" required>

            <?php
            $query = "SELECT 1 FROM users WHERE role='admin'";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $adminExists = (bool) $stmt->fetchColumn();
            ?>
            <?= $adminExists ? '' : '<label for="is_admin">Utwórz admina?</label>' ?>
            <input type="checkbox" id="is_admin" name="is_admin" <?= $adminExists ? 'hidden disabled' : '' ?>>

            <button type="submit">Utwórz konto</button>
            <p class="register-link"><a href="./loginForm.php">Zaloguj się</a></p>
        </form>

        <?php
        if (isset($_SESSION['error'])) {
            echo "<p class='error'>" . htmlspecialchars($_SESSION['error']) . "</p>";
            unset($_SESSION['error']);
        }
        ?>
    </div>

</body>
</html>