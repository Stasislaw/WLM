<!-- File: about.html -->
<?php
require_once('header.php');
if(isset($_SESSION['user_id'])){
    header('Location: index.php');
} 
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O Nas - Ligia Matematyczna</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <main class="container">
        <section class="about">
            <h2>O SOML</h2>
            <p>kys</p>
        </section>
    </main>
</body>

</html>