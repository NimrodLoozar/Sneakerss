<?php
session_start();
require_once 'config/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header('Location: login.php');
    exit();
}

// Ontvang reservering ID en actie van het formulier
$reservation_id = $_POST['reservation_id'];
$action = $_POST['action'];

// Haal de reservering op om de gebruiker te vinden
$query = "SELECT user_id FROM reservations WHERE id = :reservation_id";
$stmt = $pdo->prepare($query);
$stmt->execute(['reservation_id' => $reservation_id]);
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

if ($reservation) {
    $user_id = $reservation['user_id'];

    // Update de reservering status
    $status = ($action == 'approve') ? 'approved' : 'rejected';
    $update_query = "UPDATE reservations SET statuses = :statuses WHERE id = :reservation_id";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->execute(['statuses' => $status, 'reservation_id' => $reservation_id]);

    // Maak een bericht aan voor de gebruiker
    $message = ($status == 'approved')
        ? 'Je reservering is goedgekeurd.'
        : 'Je reservering is afgekeurd.';
    $insert_message_query = "INSERT INTO messages (user_id, messages, is_read) VALUES (:user_id, :messages, 0)";
    $insert_message_stmt = $pdo->prepare($insert_message_query);
    $insert_message_stmt->execute(['user_id' => $user_id, 'messages' => $message]);

    // Redirect terug naar het admin dashboard
    header('Location: admin_dashboard.php');
    exit();
}
