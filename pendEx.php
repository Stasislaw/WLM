<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nowe zadania</title>
</head>
<body>
    <?php
        require_once('connect.php');
        session_start();
        if(!isset($_SESSION['user_id'])){
            header('Location: index.php');
        }

        $query = "
        SELECT
            e.*,
            ( SELECT COUNT(*)
                FROM exercise_files f
            WHERE f.exercise_id = e.exercise_id
            ) AS file_count,
             s.*
        FROM exercises e
        JOIN submissions s ON e.exercise_id = s.exercise_id
        WHERE EXISTS (
            SELECT 1
            FROM submissions s
            WHERE s.exercise_id = e.exercise_id
            AND s.submitter_id = ?
        )
        ORDER BY e.created_at DESC
        ";
        

        $stmt = $pdo->prepare($query);
        $_SESSION['role'] == 'doer' ? 
        $stmt->execute([$_SESSION['user_id']]) :
        $stmt->execute();
        $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(empty($exercises)){
            echo('
            <h2>Brak zadań do wyświetlenia!</h2>
            <br><p>Jesteś na bieżąco</p>
            ');
        }else{
            foreach ($exercises as $ex){
                echo('<a 
                    href="exercise.php?id='.$ex['exercise_id'].'" 
                    style="text-decoration: none;"
                    class="newEx"
                >');
                echo('<h2>'.$ex['title'].'</h2>');
                echo('<h3>'.$ex['max_points'].' pkt. | '.$ex['difficulty'].'</h3>');

                if (mb_strlen($ex['description']) > 100) {
                    $teaser = mb_substr($ex['description'], 0, 100  ) . '…';
                } else {
                    $teaser = $ex['description'];
                }

                echo('<p>'.$teaser.'</p><hr>');
                echo('<p>'.$ex['answer'].'</p><br>');
                echo('Dołączonych plików: '.$ex['file_count']);
                echo('</a>');
            }  
        }
    ?>
</body>
</html>