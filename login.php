<?php
session_start();
include 'config/config.php';

// Initialiseer de foutmelding en pogingen
$error = '';
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = []; // Houd het aantal mislukte pogingen per gebruiker bij
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Valideer gebruikersnaam
    if (empty($username) || !preg_match('/^[a-zA-Z0-9áéíóüöőúű_]+$/', $username)) {
        $error = "Ongeldige gebruikersnaam.";
    }

    // Valideer wachtwoord
    if (empty($password)) {
        $error = "Wachtwoord mag niet leeg zijn.";
    }

    // Controleer of de gebruiker geblokkeerd is
    if (isset($_SESSION['attempts'][$username]) && $_SESSION['attempts'][$username] >= 3) {
        $error = "Je hebt te vaak een foutief wachtwoord ingevoerd. Probeer het later opnieuw.";
    }

    // Als er geen fouten zijn, ga dan verder met inloggen
    if (empty($error)) {
        // Zoek de gebruiker in de database
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Controleer het wachtwoord
        if ($user && password_verify($password, $user['password'])) {
            // Reset het aantal pogingen bij een succesvolle inlog
            if (isset($_SESSION['attempts'][$username])) {
                unset($_SESSION['attempts'][$username]); // Verwijder de pogingen voor deze gebruiker
            }

            // Sla de gebruikersinformatie op in de sessie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];

            // Redirect naar de juiste pagina
            header('Location: ' . ($user['is_admin'] ? '/admin_dashboard.php' : '/dashboard.php'));
            exit();
        } else {
            // Verhoog het aantal mislukte pogingen voor deze gebruiker
            if (!isset($_SESSION['attempts'][$username])) {
                $_SESSION['attempts'][$username] = 0;
            }
            $_SESSION['attempts'][$username]++; // Verhoog het aantal mislukte pogingen
            $error = "Ongeldige inloggegevens.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>Inloggen</h2>

        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="login.php" method="post">
            <input class="login-input" type="text" name="username" placeholder="Gebruikersnaam" required>
            <input class="login-input" type="password" name="password" placeholder="Wachtwoord" required>
            <input class="login-input" type="submit" value="Inloggen">
        </form>
        <p>Heb je nog geen account? <a href="/register">Registreer nu!</a></p>
        <a href="/">Go Back</a>
    </div>

</body>

</html>