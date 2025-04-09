<!--index.php-->
<?php
require_once('auth.php');
session_start();
checkRememberMeCookie($pdo);

if(!isset($_SESSION['user_id'])){
    header('Location: loginForm.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WLM</title>
</head>
<body>
    aha
    <a href='./logout.php'>Wyloguj</a>
</body>
</html>