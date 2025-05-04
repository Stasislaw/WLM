<!--index.php-->
<?php
require_once('auth.php');
session_start();
checkRememberMeCookie($pdo);



if(!isset($_SESSION['user_id'])){
    header('Location: news.php');
}

// Add form handling for admin users
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';
    if (!empty($title) && !empty($content)) {
        $sql = "INSERT INTO news (title, content, user_id) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $content, $_SESSION['user_id']]);
        header('Location: index.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
    // if($_SESSION['role'] == 'admin'){
    //   echo "<a href='./addNews.php'>Add News</a>";
    // } 
    ?>
    <title>SOML</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
<div class="container header-inner">
      <h1>SOML</h1>
      <nav>
        <ul>
          <li><a href="news.php">Aktualności</a></li>
          <li><a href="problems.php">Zadania</a></li>
          <li><a href="ranking.php">Ranking</a></li>
          <li><a href="about.php">O nas</a></li>
          <li><a href="./logout.php" class="btn-login">Wyloguj</a></li>
        </ul>
      </nav>
    </div>
  </header>
    <main class="container">
        <?php if($_SESSION['role'] === 'admin'): ?>
            <section class="add-news">
                <h2>Dodaj nowe aktualności</h2>
                <form method="POST" class="news-form">
                    <div class="form-group">
                        <label for="title">Tytuł:</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Treść:</label>
                        <textarea id="content" name="content" required></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Dodaj nowe aktualności</button>
                </form>
            </section>
        <?php endif; ?>

        <section class="tasks">
            <a href='./newEx.php'><?= $_SESSION['role'] == 'doer' ? 'Nowe zadania' : 'Zadania do sprawdzenia'?></a>
            <?php if($_SESSION['role'] === 'doer'): ?>
                <br><a href='./pendEx.php'>Oczekujące na sprawdzenie</a>
            <?php endif; ?>
        </section>

        <!-- Usunięto sekcję 'Ostatnie Aktualności' -->
    </main>
</body>
</html>