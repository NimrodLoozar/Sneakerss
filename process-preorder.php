<?php
session_start();
include 'config/config.php'; // Zorg ervoor dat je databaseverbindingen hebt ingesteld.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $sneakerName = $_POST['sneaker_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Controleer of de gebruiker bestaat
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        // Gebruiker bestaat niet, stuur door naar registratiepagina
        $_SESSION['message'] = "Gebruiker niet gevonden. Gelieve je te registreren.";
        header("Location: /register.php");
        exit();
    } else {
        // Gebruiker bestaat, controleer of hij ingelogd is
        if (!isset($_SESSION['user_id'])) {
            // Niet ingelogd, stuur door naar inlogpagina
            $_SESSION['message'] = "Je moet ingelogd zijn om een pre-order te plaatsen.";
            header("Location: /login.php");
            exit();
        } else {
            // Gebruiker is ingelogd, verwerk de pre-order
            // Hier kun je je pre-order logica toevoegen, bijvoorbeeld het opslaan in de database

            // Voeg een bericht toe aan de messages-tabel
            $message = "Je hebt een pre-order geplaatst voor $sneakerName. Aantal: $quantity, Prijs: $price.";
            $stmt = $pdo->prepare("INSERT INTO messages (user_id, messages, is_read) VALUES (:user_id, :messages, 0)");
            $stmt->execute([
                'user_id' => $_SESSION['user_id'],
                'messages' => $message
            ]);

            // Update de PreOrder kolom in de users-tabel door de huidige waarde met 1 te verhogen
            $stmt = $pdo->prepare("UPDATE users SET PreOrder = PreOrder + 1 WHERE id = :user_id");
            $stmt->execute(['user_id' => $user['id']]);

            // Verstuur een bevestigingsmail
            $to = $email;
            $subject = "Bevestiging Pre-order voor " . $sneakerName;
            $message = "Bedankt voor je pre-order van " . $sneakerName . ".\nAantal: " . $quantity . "\nPrijs: " . $price;
            $headers = "From: no-reply@yourdomain.com";

            mail($to, $subject, $message, $headers);

            // Redirect naar de berichtenpagina
            $_SESSION['message'] = "Je pre-order is succesvol geplaatst!";
            header("Location: /all_messages.php");
            exit();
        }
    }
}
