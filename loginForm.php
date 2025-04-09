<!--loginForm.php-->
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zaloguj się</title>
</head>
<body>
    <h2> Zaloguj się </h2>
    <form action='./login.php' method='post'>
        <label for="username">Nazwa użytkownika: </label>
        <input type='text' name="username" required>
        <label for="password">Hasło: </label>
        <input type="password" name="password" required>
        <input type="submit" value='Zaloguj się'>
    </form>
    <?php
    // Display error message if it exists
    if (isset($_SESSION['error'])) {
        echo "<p style='color:red;'>" . htmlspecialchars($_SESSION['error']) . "</p>";
        unset($_SESSION['error']); // Clear the error after displaying
    }
    if (isset($_SESSION['success'])){
        echo "<p style='color:green;'>" . htmlspecialchars($_SESSION['success']) . "</p>";
        unset($_SESSION['success']); // Clear the success message after displaying
    }
    ?>
    <a href='./registerForm.php'>Utwórz konto</a>
</body>
</html>