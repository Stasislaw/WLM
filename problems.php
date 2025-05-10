<?php
require_once('header.php'); 
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadania - Ligia Matematyczna</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <main class="container">
        <section class="problems">
            <ul>
                <?php 
                if(isset($_SESSION['user_id'])){
                ?>
                    <li><a href='allEx.php'> Wszystkie zadania </a></li>
                    <li><a href='newEx.php'> <?= $_SESSION['role'] == 'doer' ? 'Nowe zadania' : 'Zadania do sprawdzenia' ?> </a></li>
                    <li><a href='pendEx.php'> Zadania z przesłanymi rozwiązaniami </a></li> 
                <?php
                }else{
                ?>
                    <li><a href='allEx.php'> Wszystkie zadania </a></li>
                    <li>Zaloguj się aby robić zadania</li>
                <?php } ?>
            </ul>
        </section>
    </main>
</body>

</html>