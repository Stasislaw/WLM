<?php
require_once('connect.php'); // Include database connection

function checkRememberMeCookie($pdo) {
    if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
        $cookie = explode('|', $_COOKIE['remember_me']);
        $userId = $cookie[0];
        $token = $cookie[1];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ? AND remember_token = ? AND expires_at > NOW()");
        $stmt->execute([$userId, $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
        } else {
            // Cookie exists, but token is invalid or expired
            setcookie('remember_me', '', time() - 3600, '/');
            $stmt = $pdo->prepare("UPDATE users SET remember_token = NULL, expires_at = NULL WHERE user_id = ?");
            $stmt->execute([$userId]);
        }
    } else if (!isset($_SESSION['user_id']) && !isset($_COOKIE['remember_me'])) {
        $stmt = $pdo->prepare("SELECT user_id FROM users WHERE remember_token IS NOT NULL");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            foreach ($result as $row) {
                $userId = $row['user_id'];
                $stmt2 = $pdo->prepare("UPDATE users SET remember_token = NULL, expires_at = NULL WHERE user_id = ?");
                $stmt2->execute([$userId]);
            }
        }
    }
}
?>