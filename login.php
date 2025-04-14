<!--login.php-->
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

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Nazwa użytkownika i hasło są wymagane";
        header('Location: loginForm.php');
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Login successful, set session variables
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                //Add a remember-me token
                if (isset($_POST['remember'])) {
                    $rememberToken = bin2hex(random_bytes(64));
                
                    // Update the user's remember_token in the database
                    $stmt = $pdo->prepare("UPDATE users SET remember_token = ? WHERE user_id = ?");
                    $stmt->execute([$rememberToken, $user['user_id']]);

                    $date = date('Y-m-d H:i:s');
                    // Set an expiration date for token
                    $stmt = $pdo->prepare("UPDATE users SET expires_at = ? WHERE user_id = ?");
                    $stmt->execute([$date, $user['user_id']]);
                
                    // Set a cookie
                    $cookieValue = $user['user_id'] . '|' . $rememberToken;
                    setcookie('remember_me', $cookieValue, time() + (86400 * 60), "/"); // Expires in 60 days
                }

                //proceed to page
                header('Location: index.php');
                exit();
            } else {
                // Incorrect password
                $_SESSION['error'] = "Niepoprawne hasło";
                header('Location: loginForm.php');
                exit();
            }
        } else {
            // Username not found
            $_SESSION['error'] = "Użytkownik nie istnieje";
            header('Location: loginForm.php');
            exit();
        }

} else {
    // If accessed directly without POST, redirect to login form
    header('Location: loginForm.php');
    exit();
}

?>