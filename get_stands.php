<?php
require_once 'config/config.php';

// Controleer of plein_id is meegegeven
if (!isset($_GET['plain_id'])) {
    echo "<option value=''>-- Geen plein geselecteerd --</option>";
    exit();
}

$plain_id = $_GET['plain_id'];

// Haal de beschikbare stands op voor het geselecteerde plein
$query = "SELECT id, stand_number FROM stands WHERE plain_id = :plain_id AND is_available = TRUE";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':plain_id', $plain_id, PDO::PARAM_INT);
$stmt->execute();
$stands = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Controleer of er beschikbare stands zijn
if (empty($stands)) {
    echo "<option value=''>Geen beschikbare stands op dit plein</option>";
} else {
    foreach ($stands as $stand) {
        echo "<option value='{$stand['id']}'>Stand: {$stand['stand_number']}</option>";
    }
}
