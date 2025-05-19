<?php
session_start();
require_once('connect.php');
if(
    !isset($_SESSION['user_id']) ||
    !isset($_POST['title']) ||
    !isset($_POST['description']) ||
    !isset($_POST['difficulty']) ||
    !isset($_POST['max_points']) ||
    !isset($_POST['due_to'])
    ){
    header('Location: header.php');
    exit;
}
if($_SESSION['role'] == 'doer'){
    header("Location: index.php");
    exit;
}

$creator_id = $_SESSION['user_id'];
$title = trim($_POST['title']);
$description = trim($_POST['description']);
$diff = $_POST['difficulty'];
$max_pts = (int)$_POST['max_points'];
$due = $_POST['due_to'];

$sql = "INSERT INTO exercises 
              (creator_id, title, description, difficulty, max_points, due_to)
            VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    $creator_id, $title, $description, $diff, $max_pts, $due
]);
$newExerciseId = $pdo->lastInsertId();

if (!empty($_FILES['files']) && $_FILES['files']['error'][0] !== UPLOAD_ERR_NO_FILE) {
        // ensure upload directory exists
        $uploadDir = './Exercise_files';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        foreach($_FILES['files']['tmp_name'] as $idx => $tmpPath){
            $err  = $_FILES['files']['error'][$idx];
            $name = basename($_FILES['files']['name'][$idx]);

            if ($err !== UPLOAD_ERR_OK) {
                continue;
            }

            $ext       = pathinfo($name, PATHINFO_EXTENSION);
            $unique    = bin2hex(random_bytes(8)) . '.' . $ext;
            $targetPath = $uploadDir . $unique;
            
            if (move_uploaded_file($tmpPath, $targetPath)) {
                // record in database
                $sqlF = "INSERT INTO exercise_files 
                           (exercise_id, file_name, file_path)
                         VALUES (?, ?, ?)";
                $stmtF = $pdo->prepare($sqlF);
                // store relative path so you can move your code if needed
                $relPath = './Exercise_files/' . $unique;
                $stmtF->execute([$newExerciseId, $name, $relPath]);
        }
    }
    header("Location: exercise.php?id=$newExerciseId");
    exit;
}
?>