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
    <link rel="shortcut icon" href="assets/img/favicon.ico" title="Favicon" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/namari-color.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: rgb(227, 6, 19);
        background: -moz-linear-gradient(0deg, rgba(227, 6, 19, 1) 33%, rgba(186, 13, 27, 1) 74%);
        background: -webkit-linear-gradient(0deg, rgba(227, 6, 19, 1) 33%, rgba(186, 13, 27, 1) 74%);
        background: linear-gradient(0deg, rgba(227, 6, 19, 1) 33%, rgba(186, 13, 27, 1) 74%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#e30613",endColorstr="#ba0d1b",GradientType=1);
    }

    .register-container {
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        width: 320px;
        text-align: center;
    }

    .register-input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .register-input:focus {
        border-color: #ba0d1b;
        box-shadow: 0 0 5px rgba(186, 13, 27, 0.5);
        outline: none;
    }

    .register-button {
        background: linear-gradient(to right, #e30613, #ba0d1b);
        border: none;
        border-radius: 5px;
        padding: 12px;
        color: white;
        cursor: pointer;
        margin-left: -1%
    }

    .register-button:hover {
        background-color: #ba0d1b;
    }

    .error {
        color: #ff4d4d; /* Brighter red for errors */
        background-color: rgba(255, 77, 77, 0.1); /* Light background to make it stand out */
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
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