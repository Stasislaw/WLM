<!--registerForm.php-->
<?php
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
</head>
<body>
    <h2> Utwórz konto </h2>
    <form action='register.php' method='post'>
        <label for='username'>Nazwa użytkownika: </label>
        <input type='text' name='username'  required>
        <label for='password'>Hasło: </label>
        <input type='password' name='password' required>
        <label for='klasa'>Klasa: </label>
        <input type='text' name='klasa' required>
        <input type='submit' value='Dodaj użytkownika'>
    </form>

    <?php
    // Display error message if it exists
    if (isset($_SESSION['error'])) {
        echo "<p style='color:red;'>" . htmlspecialchars($_SESSION['error']) . "</p>";
        unset($_SESSION['error']); // Clear the error after displaying
    }
    ?>

    <a href='./loginForm.php'>Zaloguj się</a>
</body>
</html>