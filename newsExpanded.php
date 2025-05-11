<?php
require_once('connect.php');
if(!isset($_GET['id'])){
    header('Location: news.php');
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if($id === false){
    header('Location: news.php');
    exit;
}

$query = "SELECT n.*, (SELECT u.username FROM users u WHERE u.user_id = n.creator_id) AS 'creator_name' FROM news n WHERE n.news_id = ?";

$stmt=$pdo->prepare($query);
$stmt->execute([$id]);
$news=$stmt->fetch(PDO::FETCH_ASSOC);
if(!$news){
    header('Location: news.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $news['title'] ?></title>
</head>
<body>
    <div class='expArticle'>
        <h1><?= $news['title'] ?></h1>
        <p><i><?= $news['creator_name'] ?></i>,&nbsp;<?= $news['submitted_at'] ?></p>
        <hr>
        <p><?= $news['news'] ?></p>
    </div>
</body>
</html>