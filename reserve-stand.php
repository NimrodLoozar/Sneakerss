<?php
session_start();
include 'config.php';

// Haal event_id uit de URL
$event_id = $_GET['event_id'];

// Haal pleinen en beschikbare stands op voor dit evenement
$sql = "SELECT * FROM plains WHERE event_id = :event_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['event_id' => $event_id]);
$plains = $stmt->fetchAll();
?>

<form action="process-reservation.php" method="POST">
    <label for="company">Bedrijfsnaam:</label>
    <input type="text" id="company" name="company" required>

    <label for="plain">Kies een plein:</label>
    <select id="plain" name="plain">
        <?php foreach ($plains as $plain): ?>
            <option value="<?php echo $plain['id']; ?>"><?php echo $plain['plain_name']; ?></option>
        <?php endforeach; ?>
    </select>

    <label for="stand">Kies een stand:</label>
    <select id="stand" name="stand">
        <!-- Dynamisch stands op basis van geselecteerd plein -->
    </select>

    <button type="submit">Reserveer</button>
</form>