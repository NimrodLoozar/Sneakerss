<?php
session_start();
include 'config/config.php'; // Database verbinding

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    $_SESSION['user_id'] = $pdo->lastInsertId();
    header("Location: dashboard.php");
}
