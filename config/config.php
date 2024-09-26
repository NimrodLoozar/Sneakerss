<?php
// Database configuration
$dbHost = 'localhost';
$dbName = 'Sneaker';
$dbUser = 'DB_USER';
$dbPass = 'DB_PASS';

$dsn = "mysql:host=$dbHost;
        dbname=$dbName;
        charset=UTF8";

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>