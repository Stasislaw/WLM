<?php
require_once('header.php'); 
require_once('connect.php');
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liga Matematyczna - Strona Główna</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <main class="container">
        <section class="news">
            <h2>Aktualności</h2>
            <?php

                $query = "
                    SELECT n.*, (SELECT username FROM users u WHERE u.user_id = n.creator_id) AS creator_name FROM news n ORDER BY n.submitted_at DESC
                ";
                $stmt = $pdo->prepare($query);
                $stmt -> execute();
                $news = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if(empty($news)){
                    echo('<h2>Nie ma na razie żadnych aktualności');
                }else{
                    foreach($news as $news){
                        if (mb_strlen($news['news']) > 200) {
                            $teaser = mb_substr($news['news'], 0, 200  ) . '…';
                        } else {
                            $teaser = $news['news'];
                        }
                        ?>
                            <div class='article'>
                                <h2><?= $news['title'] ?></h2>
                                <p><?= $news['creator_name'] ?></p>
                                <hr>
                                <p><?= $teaser ?></p>
                                <a href="newsExpanded.php?id=<?= $news['news_id'] ?>"> &nbsp; Czytaj dalej...</a>
                            </div>
                        <?php
                    }
                }

            ?>
        </section>
    </main>

    <!-- <footer>
        <div class="container">
            <p>&copy; 2025 Ligia Matematyczna</p>
        </div>
    </footer> -->
</body>

</html>