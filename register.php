<?php
session_start();
include 'config/config.php'; // Zorg ervoor dat je je databaseverbinding hebt

// Initieer variabelen om gebruikersinvoer op te slaan
$name = '';
$email = '';
$errors = [];

// Verwerk de registratie wanneer het formulier is verzonden
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $defaultProfilePhoto = 'https://avatar.iran.liara.run/public/boy?username=Ash';
    $defaultCoverPhoto = 'assets/img/default/default-cover.jpg';

    // Server-side validatie
    if (empty($name) || !preg_match("/^[a-zA-Z\s]{3,}$/", $name)) {
        $errors[] = "Naam moet minimaal 3 letters bevatten en mag geen speciale tekens bevatten.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Voer een geldig e-mailadres in.";
    } else {
        // Controleer of het e-mailadres al bestaat
        $checkEmailQuery = "SELECT * FROM users WHERE email = :email";
        $checkEmailStmt = $pdo->prepare($checkEmailQuery);
        $checkEmailStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $checkEmailStmt->execute();

        if ($checkEmailStmt->rowCount() > 0) {
            $errors[] = "Dit e-mailadres is al in gebruik. Probeer een ander e-mailadres.";
        }
    }

    if (empty($password) || strlen($password) < 8 || !preg_match("/\d/", $password)) {
        $errors[] = "Wachtwoord moet minimaal 8 tekens lang zijn en ten minste één cijfer bevatten.";
    } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }

    // Controleer of er fouten zijn
    if (empty($errors)) {
        // Voer de registratie uit met standaard foto's
        $sql = "INSERT INTO users (username, email, password, profile_photo, cover_photo) 
                VALUES (:name, :email, :password, :profile_photo, :cover_photo)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $passwordHash,
            ':profile_photo' => $defaultProfilePhoto,
            ':cover_photo' => $defaultCoverPhoto
        ]);

        if ($stmt) {
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['user_name'] = $name;
            header("Location: dashboard.php");
            exit();
        } else {
            $errors[] = "Er is iets misgegaan bij het registreren. Probeer het opnieuw.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Registreren</title>
    <style>
        .error {
            color: red;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body class="relative min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/221808/sky.jpg');">
    <div class="register-container bg-white p-8 rounded-lg shadow-lg w-full max-w-md text-center">
        <h2 class="text-2xl font-semibold mb-4">Registreren</h2>

        <?php if (!empty($errors)): ?>
            <div class="error text-red-500 mb-4">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST" class="space-y-4">
            <input class="register-input w-full p-2 border border-gray-300 rounded-md" type="text" id="name" name="name" placeholder="Naam" value="<?php echo htmlspecialchars($name); ?>" required>
            <input class="register-input w-full p-2 border border-gray-300 rounded-md" type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
            <input class="register-input w-full p-2 border border-gray-300 rounded-md" type="password" id="password" name="password" placeholder="Wachtwoord" required>
            <button class="register-button w-full bg-green-500 hover:bg-green-600 text-white p-2 rounded-md font-semibold" type="submit">Registreer</button>
        </form>
        <p class="mt-4">Heb je al een account? <a href="/login" class="text-blue-500 hover:underline">Login nu!</a></p>
        <a href="/" class="text-gray-500 hover:underline">Ga terug</a>
    </div>
</body>


</html>