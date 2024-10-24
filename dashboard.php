<?php
session_start();
require_once 'config/config.php'; // Verbind met je database

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <h1>Welkom op het Sneakerness Dashboard</h1>
    <p>Je bent ingelogd als: <?php echo htmlspecialchars($_SESSION['username']); ?></p>

    <h2>Beschikbare Evenementen</h2>
    <ul>
        <?php foreach ($events as $event): ?>
            <li>
                <?php echo htmlspecialchars($event['name']); ?> - Datum: <?php echo htmlspecialchars($event['date']); ?>
                <a href="reserve_stand.php?event_id=<?php echo $event['id']; ?>">Stand huren</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="logout.php">Uitloggen</a>
</body>

</html>