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
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .error {
            color: red;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body class="relative min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/221808/sky.jpg');">
    <div class="login-container bg-white p-8 rounded-lg shadow-lg w-full max-w-md text-center">
        <h2 class="text-2xl font-semibold mb-4">Inloggen</h2>

        <?php if ($error): ?>
            <div class="error text-red-500 mb-4"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="login.php" method="post" class="space-y-4">
            <input class="login-input w-full p-2 border border-gray-300 rounded-md" type="text" name="username" placeholder="Gebruikersnaam" required>
            <input class="login-input w-full p-2 border border-gray-300 rounded-md" type="password" name="password" placeholder="Wachtwoord" required>
            <button class="login-button w-full bg-green-500 hover:bg-green-600 text-white p-2 rounded-md font-semibold" type="submit">Inloggen</button>
        </form>

        <p class="mt-4">Heb je nog geen account? <a href="/register" class="text-blue-500 hover:underline">Registreer nu!</a></p>
        <a href="/" class="text-gray-500 hover:underline">Ga terug</a>
    </div>
</body>


</html>