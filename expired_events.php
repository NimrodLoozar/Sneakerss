<?php
session_start();
include 'config/config.php'; // Verbind met je database

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Haal de evenementen op uit de database
$query = "SELECT * FROM events";
$stmt = $pdo->prepare($query);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Haal de ongelezen berichten op voor de gebruiker
$user_id = $_SESSION['user_id'];
$message_query = "SELECT id, messages, is_read FROM messages WHERE user_id = :user_id AND is_read = 0";
$message_stmt = $pdo->prepare($message_query);
$message_stmt->execute(['user_id' => $user_id]);
$messages = $message_stmt->fetchAll(PDO::FETCH_ASSOC);

// Haal reserveringen op voor de gebruiker
$reservations_query = "SELECT stand_id, company_name, statuses FROM reservations WHERE user_id = :user_id";
$reservations_stmt = $pdo->prepare($reservations_query);
$reservations_stmt->execute(['user_id' => $user_id]);
$reservation = $reservations_stmt->fetchAll(PDO::FETCH_ASSOC);

// Query om het aantal ongelezen berichten voor de gebruiker op te halen
$unreadQuery = "SELECT COUNT(*) as unread_count FROM messages WHERE user_id = :user_id AND is_read = 0";
$stmt = $pdo->prepare($unreadQuery);
$stmt->execute(['user_id' => $user_id]);
$unreadCount = $stmt->fetchColumn();

/// Haal de gebruikersgegevens op
$query = "SELECT * FROM users WHERE id = :user_id"; // Voeg de extra velden toe
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Verkrijg de waarden uit de database, of stel ze in als lege strings
    $username = $user['username'] ?? '';
    // Haal de profielfoto en coverfoto op uit de database
    $profile_photo = $user['profile_photo'] ?? 'assets/img/default/default-profile.png'; // Vul hier een standaard afbeelding in als placeholder
    $cover_photo = $user['cover_photo'] ?? 'assets/img/default/default-profile.jpg'; // Vul hier een standaard afbeelding in als placeholder
    $first_name = $user['first_name'] ?? '';
    $last_name = $user['last_name'] ?? '';
    $email = $user['email'] ?? '';
    $country = $user['country'] ?? '';
    $street = $user['street'] ?? '';
    $adres = $user['adres'] ?? '';
    $city = $user['city'] ?? '';
    $state_province = $user['state_province'] ?? '';
    $zip_postal_code = $user['zip_postal_code'] ?? '';
} else {
    // Als de gebruiker niet gevonden is, stel standaard waarden in
    $username = $email = $country = $street = $adres = $city = $state_province = $zip_postal_code = '';
}

file_put_contents('debug.log', $user['cover_photo'] . PHP_EOL, FILE_APPEND);

?>

<!DOCTYPE html>
<html class="h-full bg-gray-100" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Expired Events</title>
</head>

<body class="h-full">

    <div class="min-h-full">

        <main class="relative flex items-center justify-center h-screen overflow-hidden">
            <div class="absolute inset-0 flex items-end">
                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/221808/sky.jpg" class="object-cover w-full h-full" alt="Animated Background" />
            </div>
            <div class="relative bg-black bg-opacity-70 text-white p-8 rounded-lg text-center z-10">
                <h1 class="text-2xl font-bold mb-4">Event is Expired!</h1>
                <a href="dashboard.php" class="inline-block bg-orange-500 text-white py-2 px-4 rounded-md font-semibold transition duration-300 hover:bg-orange-600">
                    Go to Dashboard
                </a>
            </div>
        </main>

</body>

</html>