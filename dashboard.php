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

// Haal de ongelezen berichten op voor de gebruiker
$user_id = $_SESSION['user_id'];
$message_query = "SELECT id, messages FROM messages WHERE user_id = :user_id AND is_read = 0";
$message_stmt = $pdo->prepare($message_query);
$message_stmt->execute(['user_id' => $user_id]);
$messages = $message_stmt->fetchAll(PDO::FETCH_ASSOC);

$user_id = $_SESSION['user_id'];
$reservations_query = "SELECT stand_id, company_name, statuses FROM reservations WHERE user_id = :user_id";
$reservations_stmt = $pdo->prepare($reservations_query);
$reservations_stmt->execute(['user_id' => $user_id]);
$reservation = $reservations_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="shortcut icon" href="assets/img/favicon.ico" title="Favicon" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/namari-color.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
       body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        margin: 0;
        padding: 20px;
        background: rgb(227,6,19);
        background: -moz-linear-gradient(0deg, rgba(227,6,19,1) 33%, rgba(186,13,27,1) 74%);
        background: -webkit-linear-gradient(0deg, rgba(227,6,19,1) 33%, rgba(186,13,27,1) 74%);
        background: linear-gradient(0deg, rgba(227,6,19,1) 33%, rgba(186,13,27,1) 74%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#e30613",endColorstr="#ba0d1b",GradientType=1);
    }

    

    .container {
        max-width: 1200px;
        margin: auto;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #333;
        margin-bottom: 20px;
    }

    h2 {
        color: #444;
        margin-top: 30px;
        border-bottom: 2px solid #ddd;
        padding-bottom: 10px;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        background: #fff;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 15px;
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #0056b3;
    }

    a {
        color: #007bff;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    a:hover {
        color: #0056b3;
    }

    .message {
        background-color: #e7f3fe;
        border-left: 5px solid #2196F3;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
    }

    </style>

</head>

<body>
<div class="container">
    <h1>Welkom op het Sneakerness Dashboard</h1>

    <!-- Inbox Sectie -->
    <h2>Inbox</h2>
    <?php if (empty($messages)): ?>
        <p>Je hebt geen nieuwe berichten.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($messages as $message): ?>
                <li><?php echo htmlspecialchars($message['messages']); ?>
                    <form action="mark_message_read.php" method="POST" style="display:inline;">
                        <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                        <button type="submit">Markeer als gelezen</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h2>Beschikbare Evenementen</h2>
    <ul>
        <?php foreach ($events as $event): ?>
            <li>
                <?php echo htmlspecialchars($event['name']); ?> - Datum: <?php echo htmlspecialchars($event['start_date']); ?>
                <a href="reserve_stand.php?event_id=<?php echo $event['id']; ?>">Stand huren</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <ul>
        <?php foreach ($reservation as $reservations): ?>
            <li><?php echo htmlspecialchars($reservations['company_name']); ?>
                <?php echo htmlspecialchars($reservations['stand_id']); ?>
                <?php echo htmlspecialchars($reservations['statuses']); ?>
                <form action="mark_message_read.php" method="POST" style="display:inline;">
                    <input type="hidden" name="reservations_id" value="<?php echo $reservations['stand_id']; ?>">
                    <!-- <button type="submit">Markeer als gelezen</button> -->
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <ul>
        <?php
        if (isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) === 1) {
            echo ('
        <li><a href="logout.php">Uitloggen</a></li>
        <li><a href="/">Home</a></li>
        <li><a href="/admin_dashboard">Back</a></li>');
        } else {
            echo ('
        <li><a href="logout.php">Uitloggen</a></li>
        <li><a href="/">Home</a></li>');
        } ?>
    </ul>
    </div>
</body>

</html>