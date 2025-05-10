<?php
    require_once('connect.php');
    session_start();

    if(!isset($_SESSION['user_id'])){
        header('Location: header.php');
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['title']) && isset($_POST['news'])){
            $title = trim($_POST['title']);
            $news = $_POST['news'];

            if(mb_strlen($title, 'UTF-8') > 100) {
                header('Location: index.php');
            }
            if(mb_strlen($news, 'UTF-8') > 20000){
                header('Location: index.php');
            }
            $query = "
                INSERT INTO news (creator_id, title, news) VALUES (?, ?, ?)
            ";
            $stmt=$pdo->prepare($query);
            $stmt->execute([$_SESSION['user_id'], $title, $news]);

            header('Location: news.php');
        }else{
            header('Location: addNews.php');
        }
    }else{
        header('Location: index.php');
    }
?>