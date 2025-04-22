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
    <a href='./newEx.php'><?= $_SESSION['role'] == 'doer' ? 'Nowe zadania' : 'Zadania do sprawdzenia'?></a>
    <?php if($_SESSION['role'] == 'doer'){ ?>
        <br><a href='./pendEx.php'>Oczekujące na sprawdzenie</a>
    <?php } ?>
    <a href='./logout.php'>Wyloguj</a>
</body>
</html>