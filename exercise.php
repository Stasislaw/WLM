<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>exercise</title>
</head>
<body>
    <?php
        require_once('connect.php');
        session_start();
        if(!isset($_SESSION['user_id'])){
            header('Location: index.php');
        }

        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        $query = "
            SELECT e.*,
            u.username AS creator_name,
            ( SELECT AVG(points_awarded)
                FROM submissions s
            WHERE s.exercise_id = e.exercise_id 
            AND s.points_awarded IS NOT NULL ) AS avg_points
            FROM exercises e
            JOIN users u ON u.user_id = e.creator_id
            WHERE e.exercise_id = ?
        ";

        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
        $exercise = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$exercise){
            header('Location: newEx.php');
            exit();
        }
    ?>
    <h2><?= $exercise['title'] ?></h2>
    <p><b>Twórca: </b><?php
    if($_SESSION['user_id'] == $exercise['creator_id']){
        echo($exercise['creator_name'].' (Ty)');
    }else{
        echo($exercise['creator_name']);
    }
    
    ?></p>
    <p><b>Poziom trudności: </b><?php
    switch($exercise['difficulty']){
        case 'hard':
            $color = 'red';
            break;

        case 'medium':
            $color = 'orange';
            break;

        case 'easy':
            $color = 'darkgreen';
            break;
    }
    echo('<span color="'.$color.'">'.$exercise['difficulty'].'</span>');
    ?>
    <p><b>Maksymalna liczba punktów:</b> <?= (int)$exercise['max_points'] ?></p>
    <p><?php
    if($exercise['avg_points'] == null){
    echo('Nie zgłoszono jeszcze rozwiązań');
    }else{
    echo('Średnia liczba uzyskanych punktów: '.round($exercise['avg_points'], 2));
    }

    ?></p>
    <hr>
    <?= $exercise['description'] ?>
    <hr>

    <?php if($_SESSION['role'] == 'doer'){  ?>
    <h2>Twoje rozwiązanie
    <?php
    $query = "
    SELECT * FROM submissions WHERE exercise_id = ? AND submitter_id = ?
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id, $_SESSION['user_id']]);
    $submission = $stmt->fetch(PDO::FETCH_ASSOC);
    if($submission){
        switch($submission['status']){
            case 'pending':
                echo(' (oczekuje na sprawdzenie) :');
                break;
            case 'reviewed':
                echo(' (poprawne, przyznano punktów - '.$submission['points_awarded'].') :');
                break;
            case 'rejected':
                echo(' (niepoprawne) :');
                break;
        }
    }else{
        echo(': <br>BRAK');
    }
    ?>
    </h2>
    <br>
    <?= $submission !== false ? htmlspecialchars($submission['answer']) : '' ?>
    <?php
    }
    else if($_SESSION['role'] == 'creator'){
    
    
    
    
    
    }
    ?>
</body>
</html>