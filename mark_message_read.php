<?php
session_start();
require_once 'config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message_id'])) {
    // Ontvang het bericht-ID van het formulier
    $message_id = $_POST['message_id'];

    try {
        // Update de status van het bericht naar 'gelezen'
        $update_query = "UPDATE messages SET is_read = 1 WHERE id = :message_id AND user_id = :user_id";
        $stmt = $pdo->prepare($update_query);
        $stmt->execute([
            'message_id' => $message_id,
            'user_id' => $_SESSION['user_id']
        ]);

        // Controleer of het bericht succesvol is bijgewerkt
        if ($stmt->rowCount() > 0) {
            $_SESSION['message'] = "Bericht gemarkeerd als gelezen.";
        } else {
            $_SESSION['error'] = "Bericht niet gevonden of u bent niet bevoegd om dit bericht te lezen.";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Er is een fout opgetreden: " . $e->getMessage();
    }
} else {
    $_SESSION['error'] = "Ongeldig verzoek.";
}

// Redirect terug naar het dashboard
header('Location: dashboard.php');
exit();
