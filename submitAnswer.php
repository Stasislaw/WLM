<?php
require_once('connect.php');
session_start();
if(!isset($_SESSION['user_id']) || !isset($_POST['submission']) || !isset($_GET['id'])){
    header('Location: index.php');
}

$answer = trim($_POST['submission']);
$ex_id = (int)$_GET['id'];
$us_id = $_SESSION['user_id'];


if (mb_strlen($answer, 'UTF-8') > 20000) {
    echo('<script>history.back()</script>');
    exit;
}

$query="
    SELECT submission_id
    FROM submissions
    WHERE exercise_id = ?
    AND submitter_id = ?
";
$stmt = $pdo->prepare($query);
$stmt->execute([$ex_id, $us_id]);
$existingId = $stmt->fetchColumn();


if($existingId){
    $query="
    UPDATE submissions
    SET answer         = ?,
        status         = 'pending',
        review         = NULL,
        points_awarded = NULL,
        submitted_at   = CURRENT_TIMESTAMP
    WHERE submission_id = ?
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$answer, $existingId]);
}else{
    $query="
        INSERT INTO submissions (exercise_id, submitter_id, answer) VALUES (?, ?, ?)
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$ex_id, $us_id, $answer]);
}

echo('<script>history.back()</script>');
exit;

?>