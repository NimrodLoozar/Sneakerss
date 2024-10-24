<?php
// Haal evenementen op uit de database
$sql = "SELECT * FROM events";
$stmt = $pdo->query($sql);
$events = $stmt->fetchAll();
?>

<div class="events">
    <?php foreach ($events as $event): ?>
        <div class="event-card">
            <h3><?php echo $event['name']; ?></h3>
            <p><?php echo $event['date']; ?></p>
            <a href="reserve-stand.php?event_id=<?php echo $event['id']; ?>">Huur een stand</a>
        </div>
    <?php endforeach; ?>
</div>