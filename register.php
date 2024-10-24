<?php
session_start();
include 'config/config.php'; // Zorg ervoor dat je je databaseverbinding hebt

// Verwerk de registratie wanneer het formulier is verzonden
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Controleer of het e-mailadres al bestaat
    $checkEmailQuery = "SELECT * FROM users WHERE email = :email";
    $checkEmailStmt = $pdo->prepare($checkEmailQuery);
    $checkEmailStmt->bindParam(':email', $email, PDO::PARAM_STR);
    $checkEmailStmt->execute();

    if ($checkEmailStmt->rowCount() > 0) {
        $error = "Dit e-mailadres is al in gebruik. Probeer een ander e-mailadres.";
    } else {
        // Voer de registratie uit
        $sql = "INSERT INTO users (username, email, password) VALUES (:name, :email, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

        // Sla de gebruikersinformatie op in de sessie
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['user_name'] = $name; // Sla de naam op in de sessie
        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Registreren</title>
    <style>
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="register-container">
        <h2>Registreren</h2>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <input class="register-input" type="text" id="name" name="name" placeholder="Naam" required>
            <input class="register-input" type="email" id="email" name="email" placeholder="Email" required>
            <input class="register-input" type="password" id="password" name="password" placeholder="Wachtwoord" required>
            <button class="register-button" type="submit">Registreer</button>
        </form>
        <p>Heb je al een account? <a href="/login">Login nu!</a></p>
        <a href="/">Go Back</a>
    </div>

</body>

</html>