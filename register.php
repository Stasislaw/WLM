<!--register.php-->
<?php
require_once('connect.php');
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    //Check if username is correct:
        if (strlen($username) < 3) {
            $_SESSION['error'] = "Nazwa użytkownika musi mieć przynajmniej 3 znaki";
            header('Location: registerForm.php');
            exit();
        } elseif (strlen($username) > 16) {
            $_SESSION['error'] = "Nazwa użytkownika nie może mieć więcej niż 16 znaków";
            header('Location: registerForm.php');
            exit();
        } elseif (preg_match('/\s/', $username)) {
            $_SESSION['error'] = "Nazwa użytkownika nie może zawierać spacji";
            header('Location: registerForm.php');
            exit();
        } elseif (!preg_match('/^[a-zA-Z0-9_-]+$/', $username)) {
            $_SESSION['error'] = "Nazwa użytkownika może zawierać tylko litery, cyfry, - oraz _";
            header('Location: registerForm.php');
            exit();
        }
    //Check if password is correct
        if(strlen($password) < 5) {
            $_SESSION['error'] = "Hasło musi mieć przynajmniej 5 znaków";
            header('Location: registerForm.php');
            exit();
        } elseif(strlen($password) > 20) {
            $_SESSION['error'] = "Hasło może mieć maksymalnie 20 znaków";
            header('Location: registerForm.php');
            exit();
        }

    //If everything is okay, proceed to adding a user
    try {
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetchColumn() > 0) {
            $_SESSION['error'] = "Nazwa użytkownika jest już zajęta";
            header('Location: registerForm.php');
            exit();
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user (role defaults to 'doer')
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hashed_password]);

        // Redirect to login with success message
        $_SESSION['success'] = "Konto zostało utworzone. Możesz się teraz zalogować.";
        header('Location: loginForm.php');
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Błąd bazy danych: " . $e->getMessage();
        header('Location: registerForm.php');
        exit();
    }

}else{
    header('Location: registerForm.php');
    exit();
}
?>