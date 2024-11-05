<?php
// Inclusie van de databaseconfiguratie
include 'config/config.php';

// Verbindingsfoutmelding variabele
$error = "";

// Verwerking van het formulier na indiening
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Ontvang en filter de invoer
        $name = htmlspecialchars(trim($_POST['name']));
        $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);

        if ($email === false) {
            throw new Exception("Ongeldig e-mailadres.");
        }

        // Voeg inschrijving toe aan de database
        $stmt = $pdo->prepare("INSERT INTO subscriptions (name, email) VALUES (:name, :email)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $message = "Bedankt voor je inschrijving!";
    } catch (PDOException $e) {
        // Controleer op specifieke foutcode voor duplicaten
        if ($e->getCode() === '23000') {
            $error = "Dit e-mailadres is al geregistreerd bij onze nieuwsbrief.";
        } else {
            $error = "Er is een fout opgetreden: " . $e->getMessage();
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}


?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <link rel="shortcut icon" href="assets/img/favicon.ico" title="Favicon" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwsbrief Aanmelden</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="relative min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/221808/sky.jpg');">
    <div class="bg-gray-200 p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Schrijf je in voor onze nieuwsbrief</h1>

        <!-- Success- of foutmelding -->
        <?php if (!empty($message)) : ?>
            <p class="text-green-500 mb-4"><?php echo htmlspecialchars($message); ?></p>
        <?php elseif (!empty($error)) : ?>
            <p class="text-red-500 mb-4"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form action="subscribe.php" method="post">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Naam:</label>
                <input type="text" id="name" name="name" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">E-mailadres:</label>
                <input type="email" id="email" name="email" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg w-full">Aanmelden</button>
        </form>
        <a href="/" class="block text-center mt-6 text-blue-500 hover:underline">
            Terug naar de homepage
        </a>
    </div>
</body>

</html>