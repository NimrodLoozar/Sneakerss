<?php
session_start();
require_once 'config/config.php'; // Verbind met je database

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Controleer of het event_id is doorgegeven
if (!isset($_GET['event_id'])) {
    header('Location: dashboard.php');
    exit();
}

$event_id = $_GET['event_id'];

// Haal het geselecteerde evenement op
$query = "SELECT * FROM events WHERE id = :event_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
$stmt->execute();
$event = $stmt->fetch(PDO::FETCH_ASSOC);

// Haal pleinen en beschikbare stands op voor het evenement
$query = "
    SELECT p.id as plain_id, p.plain_name, s.id as stand_id, s.stand_number
    FROM plains p
    JOIN stands s ON p.id = s.plain_id
    WHERE p.event_id = :event_id AND s.is_available = TRUE
";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
$stmt->execute();
$stands = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verwerk het formulier
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company_name = $_POST['company_name'];
    $stand_id = $_POST['stand_id'];

    // Reserveer de stand
    $query = "INSERT INTO reservations (user_id, stand_id, company_name) VALUES (:user_id, :stand_id, :company_name)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(':stand_id', $stand_id, PDO::PARAM_INT);
    $stmt->bindParam(':company_name', $company_name, PDO::PARAM_STR);

    if ($stmt->execute()) {
        // Update stand beschikbaarheid
        $query = "UPDATE stands SET is_available = FALSE WHERE id = :stand_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':stand_id', $stand_id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect naar dashboard met succesbericht
        header('Location: dashboard.php?success=Stand succesvol gereserveerd!');
        exit();
    } else {
        $error = "Er is een fout opgetreden bij het reserveren van de stand.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stand Huren voor <?php echo htmlspecialchars($event['name']); ?></title>
</head>

<body>
    <h1>Reserveer een stand voor <?php echo htmlspecialchars($event['name']); ?></h1>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="reserve_stand.php?event_id=<?php echo $event_id; ?>" method="POST">
        <label for="company_name">Bedrijfsnaam:</label>
        <input type="text" name="company_name" id="company_name" required>

        <label for="stand_id">Kies een beschikbare stand:</label>
        <select name="stand_id" id="stand_id" required>
            <?php foreach ($stands as $stand): ?>
                <option value="<?php echo $stand['stand_id']; ?>">
                    Plein: <?php echo $stand['plain_name']; ?> - Stand: <?php echo $stand['stand_number']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Reserveer Stand</button>
    </form>

    <a href="dashboard.php">Terug naar het Dashboard</a>
</body>

</html>