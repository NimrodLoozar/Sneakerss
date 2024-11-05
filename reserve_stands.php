<?php
session_start();
require_once 'config/config.php'; // Verbind met de database

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Haal de user_id uit de sessie
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company_name = $_POST['company_name'];
    $stand_id = $_POST['stand_id'];
    $days = $_POST['days'];
    $about = $_POST['about'];  // Hier wordt de 'about' tekst uit het formulier opgehaald
    $status = "Pending";  // Standaard status voor de reservering

    // Haal standinformatie op
    $query = "SELECT * FROM stands WHERE id = :stand_id AND is_available = TRUE";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':stand_id', $stand_id, PDO::PARAM_INT);
    $stmt->execute();
    $stand = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stand) {
        // Bereken de totale prijs
        $total_price = $stand['price_per_day'] * $days;

        // Reserveer de stand
        $query = "INSERT INTO reservations (user_id, stand_id, company_name, statuses, days, total_price, about) 
                  VALUES (:user_id, :stand_id, :company_name, :statuses, :days, :total_price, :about)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':stand_id', $stand_id, PDO::PARAM_INT);
        $stmt->bindParam(':company_name', $company_name, PDO::PARAM_STR);
        $stmt->bindParam(':statuses', $status, PDO::PARAM_STR);
        $stmt->bindParam(':days', $days, PDO::PARAM_INT);
        $stmt->bindParam(':total_price', $total_price, PDO::PARAM_STR);
        $stmt->bindParam(':about', $about, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Update de beschikbaarheid van de stand
            $query = "UPDATE stands SET is_available = FALSE WHERE id = :stand_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':stand_id', $stand_id, PDO::PARAM_INT);
            $stmt->execute();

            // Redirect naar dashboard met succesbericht
            header('Location: dashboard.php?success=Stand succesvol gereserveerd!');
            exit();
        } else {
            echo "Er is een fout opgetreden bij het reserveren van de stand.";
        }
    } else {
        echo "De gekozen stand is niet meer beschikbaar. Kies een andere stand.";
    }
} else {
    echo "Ongeldig verzoek.";
}
