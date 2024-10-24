<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company = $_POST['company'];
    $stand_id = $_POST['stand'];
    $user_id = $_SESSION['user_id'];

    // Controleer of de stand nog beschikbaar is
    $sql = "SELECT * FROM stands WHERE id = :stand_id AND is_available = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['stand_id' => $stand_id]);
    $stand = $stmt->fetch();

    if ($stand) {
        // Reservering opslaan
        $sql = "INSERT INTO reservations (user_id, stand_id, company_name) VALUES (:user_id, :stand_id, :company)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id, 'stand_id' => $stand_id, 'company' => $company]);

        // Markeer stand als bezet
        $sql = "UPDATE stands SET is_available = 0 WHERE id = :stand_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['stand_id' => $stand_id]);

        header("Location: home.php");
    } else {
        echo "De stand is niet meer beschikbaar.";
    }
}
