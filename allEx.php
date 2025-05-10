<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wszystkie zadania</title>
</head>
<body>
    <?php
        require_once('connect.php');
        session_start();

        $query = "
            SELECT e.*,
            ( SELECT COUNT(*)
                FROM exercise_files f
            WHERE f.exercise_id = e.exercise_id
            ) AS file_count
            FROM exercises e ORDER BY created_at DESC
        ";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(empty($exercises)){
            echo('<h2> Nie ma żadnych zadań </h2>
                  <br><p> Sus </p>
            ');
        }else{
            foreach($exercises as $ex){
                echo('<a 
                    href="exercise.php?id='.$ex['exercise_id'].'" 
                    style="text-decoration: none;"
                    class="newEx"
                >');
                echo('<h2>'.$ex['title'].'</h2>');
                echo('<h3>'.$ex['max_points'].' pkt. | '.$ex['difficulty'].'</h3>');

                if (mb_strlen($ex['description']) > 200) {
                    $teaser = mb_substr($ex['description'], 0, 200  ) . '…';
                } else {
                    $teaser = $ex['description'];
                }

                echo('<p>'.$teaser.'</p>');
                echo('Dołączonych plików: '.$ex['file_count']);
                echo('</a>');
            }
        }
    ?>
</body>
</html>