<?php
include 'config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['section_id'])) {
    $section_id = $_POST['section_id'];
    $is_visible = $_POST['is_visible'];

    $sql = "UPDATE sections SET is_visible = :is_visible WHERE id = :section_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':is_visible' => $is_visible, ':section_id' => $section_id]);

    echo json_encode(['success' => true]);
}
