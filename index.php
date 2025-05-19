<!--index.php-->
<?php
require_once('auth.php');
session_start();
checkRememberMeCookie($pdo);

if(isset($_SESSION['user_id'])){
    header('Location: main.php');
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOML</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <div class="container">
        <div class="headerContainer">
            <header class="logoContainer">
                <img src="./Assets/Images/logo.png" class="logo">
            </header>
            <header class="title">
                <h1>Summer Online Maths League</h1>
            </header>
        </div>
        <aside>
            <a href="sus">adadada</a>
            <a href="sus2">adadawd</a>
            <a href="adawd">dawdad</a>
            <a href="adawd">waddawfa</a>
            <a href="dawd">j fafadw</a>
        </aside>
        <main>
            adadadadadd
        </main>
        <footer>

            <a href="https://discord.gg/RnaUUcfX"><img src="./Assets/Images/discord.png" width="3%" height="3%">&nbsp;Discord</a>
            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=twojamama@gmail.com"
                    target="_blank"
                    rel="noopener">
            <img src="./Assets/Images/gmail.png" width="3%" height="3%">&nbsp;Mail</a>
        </footer>
        <footer>

        </footer>
    </div>
</body>
</html>