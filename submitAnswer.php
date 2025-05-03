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

$update = "
  UPDATE submissions
     SET answer         = ?,
         status         = 'pending',
         review         = NULL,
         points_awarded = NULL,
         submitted_at   = CURRENT_TIMESTAMP
   WHERE exercise_id   = ?
     AND submitter_id  = ?
";
$stmt = $pdo->prepare($update);
$stmt->execute([$answer, $ex_id, $us_id]);

if ($stmt->rowCount() === 0) {
    // no rows updated → really insert a new one
    $insert = "
      INSERT INTO submissions (exercise_id, submitter_id, answer)
      VALUES (?, ?, ?)
    ";
    $stmt = $pdo->prepare($insert);
    $stmt->execute([$ex_id, $us_id, $answer]);
}

echo('<script>history.back()</script>');
exit;

?>