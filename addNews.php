<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('Location: header.php');
}
if($_SESSION['role'] == 'doer'){
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj news</title>
</head>
<body>
    <form method="POST" action="newNews.php">
        <label for='title'>Tytuł: </label>
        <input type='text' name='title' id='title' required><br>
        <label for='news'>Treść: </label><br>
        <textarea name='news' id='news' required></textarea><br>
        <input type='submit' value='dodaj'>
    </form>
</body>
</html>