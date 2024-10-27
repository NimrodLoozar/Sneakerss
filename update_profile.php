<?php
session_start();
include 'config/config.php'; // Verbind met je database

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['user_id'];
    $username = $_POST['username'];
    $about = $_POST['about'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];

    // Verwerk de profielfoto
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
        $profilePhoto = 'assets/img/uploads/profile_' . $userId . '_' . basename($_FILES['profile_photo']['name']);
        move_uploaded_file($_FILES['profile_photo']['tmp_name'], $profilePhoto);
    } else {
        // Haal de huidige profielfoto op uit de database als er geen nieuwe foto is geüpload
        $stmt = $pdo->prepare("SELECT profile_photo FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        $profilePhoto = $stmt->fetchColumn();
    }

    // Verwerk de coverfoto
    if (isset($_FILES['cover_photo']) && $_FILES['cover_photo']['error'] == 0) {
        $coverPhoto = 'assets/img/uploads/cover_' . $userId . '_' . basename($_FILES['cover_photo']['name']);
        move_uploaded_file($_FILES['cover_photo']['tmp_name'], $coverPhoto);
    } else {
        // Haal de huidige coverfoto op uit de database als er geen nieuwe foto is geüpload
        $stmt = $pdo->prepare("SELECT cover_photo FROM users WHERE id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        $coverPhoto = $stmt->fetchColumn();
    }

    // Update de gebruiker in de database
    $sql = "UPDATE users SET username = :username, about = :about, first_name = :first_name, last_name = :last_name, profile_photo = :profile_photo, cover_photo = :cover_photo WHERE id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':about', $about);
    $stmt->bindParam(':first_name', $firstName);
    $stmt->bindParam(':last_name', $lastName);
    $stmt->bindParam(':profile_photo', $profilePhoto);
    $stmt->bindParam(':cover_photo', $coverPhoto);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();

    // Terug naar het dashboard
    header('Location: dashboard.php');
    exit();
}
