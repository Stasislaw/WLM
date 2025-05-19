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
    <title>Dodaj zadanie</title>
</head>
<body>
    <form action='newExercise.php' method="POST" enctype="multipart/form-data">
        <label for='title'>Tytuł zadania: </label>
        <input type="text" name="title" id="title" required><br>
        <label for="description">Treść zadania:</label><br>
        <textarea name="description" id="description" required></textarea><br>
        <label for='difficulty'>Trudność:</label>
        <select name="difficulty" id="difficulty" required>
            <option value="easy">Łatwa</option>
            <option value="medium">Średnia</option>
            <option value="hard">Trudna</option>
        </select><br>
        <label for="max_points">Maksymalna liczba punktów: </label>
        <input type="number" id="max_points" name="max_points" required><br>
        <label for="due_to">Termin wyłączenia zadania: </label>
        <input type="datetime-local" id="due_to" name="due_to" required><br>
        <label for='files'>Dołączone pliki:</label>
        <input type='file' id="files" name="files[]" multiple><br>
        <input type="submit" value="Dodaj">
    </form>
</body>
</html>