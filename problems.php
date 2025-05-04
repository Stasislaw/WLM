<?php
require_once('auth.php');
session_start();
checkRememberMeCookie($pdo);
// redirect to login if not logged in
if(!isset($_SESSION['user_id'])){
    header('Location: loginForm.php');
    exit();
}
require_once('connect.php');

// fetch exercises
$currentTasks = [];
$pastTasks = [];
try {
    $sqlCur = "SELECT e.exercise_id, e.title, e.due_date, f.file_path
               FROM exercises e
               LEFT JOIN exercise_files f ON e.exercise_id = f.exercise_id
               WHERE e.due_date >= NOW()
               ORDER BY e.due_date ASC";
    $stmtCur = $pdo->query($sqlCur);
    $currentTasks = $stmtCur->fetchAll(PDO::FETCH_ASSOC);

    $sqlPast = "SELECT e.exercise_id, e.title, e.due_date, f.file_path
                FROM exercises e
                LEFT JOIN exercise_files f ON e.exercise_id = f.exercise_id
                WHERE e.due_date < NOW()
                ORDER BY e.due_date DESC";
    $stmtPast = $pdo->query($sqlPast);
    $pastTasks = $stmtPast->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // handle error
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zadania</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php require_once('header.php'); ?>
    <main class="container">
        <?php if($_SESSION['role'] === 'admin'): ?>
            <div class="admin-actions">
                <a href="addExercise.php" class="btn-add-news">Dodaj nowe zadanie</a>
            </div>
        <?php endif; ?>

        <section class="problems current-problems">
            <h2>Zadania aktualne</h2>
            <?php if(empty(
                $currentTasks
            )): ?>
                <p>Brak aktualnych zadań.</p>
            <?php else: ?>
                <ul>
                    <?php foreach($currentTasks as $task): ?>
                        <li>
                            <a href="<?= htmlspecialchars($task['file_path']) ?>" class="task-item" target="_blank">
                                <span class="task-title"><?= htmlspecialchars($task['title']) ?></span>
                                <span class="due-date"><?= date('d.m.Y H:i', strtotime($task['due_date'])) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <section class="problems past-problems">
            <h2>Zadania z poprzednich tygodni</h2>
            <?php if(empty($pastTasks)): ?>
                <p>Brak zadań z poprzednich tygodni.</p>
            <?php else: ?>
                <ul>
                    <?php foreach($pastTasks as $task): ?>
                        <li>
                            <a href="<?= htmlspecialchars($task['file_path']) ?>" class="task-item" target="_blank">
                                <span class="task-title"><?= htmlspecialchars($task['title']) ?></span>
                                <span class="due-date"><?= date('d.m.Y H:i', strtotime($task['due_date'])) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </main>
</body>

</html>