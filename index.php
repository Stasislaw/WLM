<!--index.php-->
<?php
require_once('auth.php');
session_start();
checkRememberMeCookie($pdo);

if(!isset($_SESSION['user_id'])){
    header('Location: news.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WLM</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <div class="container header-inner">
      <h1>Liga Matematyczna</h1>
      <nav>
        <ul>
          <li><a href="news.php">Aktualności</a></li>
          <li><a href="problems.php">Zadania</a></li>
          <li><a href="ranking.php">Ranking</a></li>
          <li><a href="about.php">O nas</a></li>
          <li><a href="./logout.php" class="btn-login">Wyloguj</a></li>
          <?= $_SESSION['role'] == 'admin' || $_SESSION['role'] == 'creator' ? 
          '<li><a href="addNews.php"> Dodaj news </a></li>
           <li><a href="addExercise.php">Dodaj zadanie</a></li>'
          : '' ?>
        </ul>
      </nav>
    </div>
  </header>
    <a href='./newEx.php'><?= $_SESSION['role'] == 'doer' ? 'Nowe zadania' : 'Zadania do sprawdzenia'?></a>
    <?php if($_SESSION['role'] == 'doer'){ ?>
        <br><a href='./pendEx.php'>Oczekujące na sprawdzenie</a>
    <?php } ?>
</body>
</html>