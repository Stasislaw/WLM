<!--connect.php-->
<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$port = 3306;

$dsn = "mysql:host=$host;port=$port;charset=utf8mb4";

$pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

//create database
$dbName = 'my_database';
$sql = "CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
$pdo->exec($sql);

$dsnDb = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";
try{
    $pdo = new PDO($dsnDb, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (PDOException $e) {
    die("Connection to database failed: " . $e->getMessage());
}

$sqlUsers = "CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('creator', 'doer') DEFAULT 'doer',
    avg_score INT DEFAULT 0,
    total_score INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
$pdo->exec($sqlUsers);

$sqlExercises = "CREATE TABLE IF NOT EXISTS exercises (
    exercise_id INT AUTO_INCREMENT PRIMARY KEY,
    creator_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    difficulty ENUM('easy', 'medium', 'hard') DEFAULT 'medium',
    max_points INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (creator_id) REFERENCES users(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
$pdo->exec($sqlExercises);

$sqlSubmissions = "CREATE TABLE IF NOT EXISTS submissions (
    submission_id INT AUTO_INCREMENT PRIMARY KEY,
    exercise_id INT NOT NULL,
    submitter_id INT NOT NULL,
    answer TEXT NOT NULL,
    review TEXT,
    points_awarded INT,
    submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'reviewed', 'rejected') DEFAULT 'pending',
    FOREIGN KEY (exercise_id) REFERENCES exercises(exercise_id),
    FOREIGN KEY (submitter_id) REFERENCES users(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
$pdo->exec($sqlSubmissions);

$sqlFiles = "CREATE TABLE IF NOT EXISTS exercise_files (
    file_id INT AUTO_INCREMENT PRIMARY KEY,
    exercise_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    FOREIGN KEY (exercise_id) REFERENCES exercises(exercise_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
$pdo->exec($sqlFiles);

?>