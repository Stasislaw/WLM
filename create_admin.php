<?php
require_once('connect.php');

// Użycie: http://.../create_admin.php?username=NAZWA&password=HASLO
$username = $_GET['username'] ?? 'Krzysztof';
$password = $_GET['password'] ?? 'krzysztof';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    // Upewnij się, że enum role zawiera 'admin'
    $pdo->exec("ALTER TABLE users MODIFY role ENUM('creator','doer','admin') NOT NULL DEFAULT 'doer'");

    // Sprawdź, czy użytkownik już istnieje
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Zaktualizuj rolę na admin
        $stmt = $pdo->prepare("UPDATE users SET role = 'admin' WHERE username = ?");
        $stmt->execute([$username]);
        echo "Rola użytkownika '$username' została zaktualizowana na 'admin'.";
    } else {
        // Utwórz nowego admina
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role, klasa) VALUES (?, ?, 'admin', '')");
        $stmt->execute([$username, $hashedPassword]);
        echo "Utworzono nowego admina: '$username'.";
    }
} catch (PDOException $e) {
    echo "Błąd: " . $e->getMessage();
}
?> 