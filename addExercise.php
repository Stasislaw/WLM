<?php
require_once('auth.php');
session_start();
checkRememberMeCookie($pdo);

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin'){
    header('Location: problems.php');
    exit();
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $due_date = $_POST['due_date'] ?? '';
    $max_points = intval($_POST['max_points'] ?? 0);

    if (empty($title) || empty($due_date) || $max_points <= 0) {
        $errors[] = 'Proszę wypełnić wszystkie pola i podać prawidłową liczbę punktów.';
    }

    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['pdf']['tmp_name'];
        $fileName = basename($_FILES['pdf']['name']);
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if ($ext !== 'pdf') {
            $errors[] = 'Można przesłać tylko plik PDF.';
        }
    } else {
        $errors[] = 'Plik PDF jest wymagany.';
    }

    if (empty($errors)) {
        // Insert exercise
        $stmt = $pdo->prepare("INSERT INTO exercises (creator_id, title, description, difficulty, max_points, due_date) VALUES (?, ?, '', 'medium', ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $title, $max_points, $due_date]);
        $exercise_id = $pdo->lastInsertId();

        // Handle file upload
        $uploadDir = __DIR__ . '/pdfs/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $newFileName = 'exercise_' . $exercise_id . '_' . time() . '.pdf';
        move_uploaded_file($fileTmp, $uploadDir . $newFileName);

        // Save file record
        $stmt2 = $pdo->prepare("INSERT INTO exercise_files (exercise_id, file_name, file_path) VALUES (?, ?, ?)");
        $stmt2->execute([$exercise_id, $fileName, 'pdfs/' . $newFileName]);

        header('Location: problems.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj zadanie</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require_once('header.php'); ?>
    <main class="container">
        <section class="add-exercise">
            <h2>Dodaj nowe zadanie</h2>
            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $err): ?>
                    <p class="error"><?= htmlspecialchars($err) ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data" class="exercise-form">
                <div class="form-group">
                    <label for="title">Tytuł zadania:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="max_points">Maksymalna liczba punktów:</label>
                    <input type="number" id="max_points" name="max_points" min="1" required>
                </div>
                <div class="form-group">
                    <label for="due_date">Termin przesyłania:</label>
                    <input type="datetime-local" id="due_date" name="due_date" required>
                </div>
                <div class="form-group">
                    <label for="pdf">Plik PDF:</label>
                    <input type="file" id="pdf" name="pdf" accept="application/pdf" required>
                </div>
                <button type="submit" class="btn-submit">Dodaj zadanie</button>
            </form>
        </section>
    </main>
</body>
</html> 