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

        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <input class="register-input" type="text" id="name" name="name" placeholder="Naam" value="<?php echo htmlspecialchars($name); ?>" required>
            <input class="register-input" type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>" required>
            <input class="register-input" type="password" id="password" name="password" placeholder="Wachtwoord" required>
            <button class="register-button" type="submit">Registreer</button>
        </form>
        <p>Heb je al een account? <a href="/login">Login nu!</a></p>
        <a href="/">Go Back</a>
    </div>
</body>

</html>