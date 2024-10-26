<?php
session_start();
include 'config/config.php'; // Verbind met je database

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];

// Verwijder de gebruiker uit de database
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();

// Log de gebruiker uit en verwijder de sessie
session_destroy();

// Terug naar de homepage of loginpagina
header('Location: login.php');
exit();
