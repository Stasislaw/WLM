<!-- File: index.html -->
<?php
require_once('header.php');
require_once('connect.php');
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktualności</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <main class="container">
        <?php if(isset($_SESSION['user_id']) && $_SESSION['role'] == 'admin'): ?>
            <div class="admin-actions">
                <a href="addNews.php" class="btn-add-news">Dodaj aktualność</a>
            </div>
        <?php endif; ?>
        
        <section class="news">
            <h2>Ostatnie Aktualności</h2>
            <?php
            $sql = "SELECT n.*, u.username 
                    FROM news n 
                    JOIN users u ON n.user_id = u.user_id 
                    ORDER BY n.created_at DESC";
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <article class="news-item">
                    <h3><?= htmlspecialchars($row['title']) ?></h3>
                    <p class="news-meta">Dodane przez: <?= htmlspecialchars($row['username']) ?> 
                        dnia <?= date('d.m.Y H:i', strtotime($row['created_at'])) ?></p>
                    <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
                </article>
            <?php endwhile; ?>
        </section>
    </main>

    <!-- <footer>
        <div class="container">
            <p>&copy; 2025 Ligia Matematyczna</p>
        </div>
    </footer> -->
</body>

</html>