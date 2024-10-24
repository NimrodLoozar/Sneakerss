<?php
include 'config.php';

$plain_id = $_GET['plain_id'];

$sql = "SELECT * FROM stands WHERE plain_id = :plain_id AND is_available = 1";
$stmt = $pdo->prepare($sql);
$stmt->execute(['plain_id' => $plain_id]);
$stands = $stmt->fetchAll();

foreach ($stands as $stand) {
    echo "<option value='{$stand['id']}'>Stand {$stand['stand_number']}</option>";
}
