<?php
session_start();
require_once 'config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Ontvang het bericht-ID van het formulier
$message_id = $_POST['message_id'];

// Update de status van het bericht naar 'gelezen'
$update_query = "UPDATE messages SET is_read = 1 WHERE id = :message_id AND user_id = :user_id";
$stmt = $pdo->prepare($update_query);
$stmt->execute(['message_id' => $message_id, 'user_id' => $_SESSION['user_id']]);

// Redirect terug naar het dashboard
header('Location: dashboard.php');
exit();
