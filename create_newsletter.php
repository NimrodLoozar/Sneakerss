<?php
// Inclusie van de databaseconfiguratie
require 'config/config.php';

$message = "";

// Maak een nieuwe PHPMailer-instantie
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Zorg ervoor dat je PHPMailer hebt geïnstalleerd via Composer

$mail = new PHPMailer(true); // Initialiseer PHPMailer

// Verwerking van het formulier na indiening
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Ontvang en filter de invoer
        $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Gebruik een andere filter
        $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Gebruik een andere filter

        // Server instellingen
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = '9d38dbd4f2fdeb'; // Vervang door je Mailtrap gebruikersnaam
        $mail->Password = '6da441f959a289'; // Vervang door je Mailtrap wachtwoord
        $mail->SMTPSecure = 'tls';
        $mail->Port = 2525; // Of 587

        // Inhoud van de e-mail
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        // Haal alle abonnees op
        $sql = "SELECT email FROM subscriptions"; // Zorg ervoor dat je een tabel 'subscriptions' hebt
        $stmt = $pdo->query($sql);
        $subscribers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Voeg abonnees toe
        foreach ($subscribers as $subscriber) {
            $mail->addAddress($subscriber['email']);
        }

        // Verzend de e-mail
        $mail->setFrom('your_email@example.com', 'Jouw Naam'); // Vervang door je e-mailadres
        $mail->send();
        $message = "Nieuwsbrief succesvol verzonden!";
    } catch (Exception $e) {
        $message = "Nieuwsbrief kon niet worden verzonden. Mailer Error: {$mail->ErrorInfo}";
    } catch (PDOException $e) {
        $message = "Er is een fout opgetreden: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="assets/img/favicon.ico" title="Favicon" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwe Nieuwsbrief Aanmaken</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="relative min-h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/221808/sky.jpg');">
    <div class="bg-gray-200 p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Nieuwe Nieuwsbrief Aanmaken</h1>

        <!-- Success- of foutmelding -->
        <?php if ($message): ?>
            <p class="text-green-500 mb-4"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form action="create_newsletter.php" method="post">
            <div class="mb-4">
                <label for="subject" class="block text-gray-700">Onderwerp:</label>
                <input type="text" id="subject" name="subject" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="body" class="block text-gray-700">Inhoud:</label>
                <textarea id="body" name="body" rows="5" class="w-full p-2 border border-gray-300 rounded-md" required></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg w-full">Nieuwsbrief Versturen</button>
        </form>
        <a href="/admin_dashboard" class="block text-center mt-6 text-blue-500 hover:underline">
            Terug naar de Admin Dashboard
        </a>
    </div>
</body>

</html>