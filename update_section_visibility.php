<?php
include 'config/config.php';

if (isset($_POST['section_name'], $_POST['is_visible'])) {
    $sectionName = $_POST['section_name'];
    $isVisible = (int) $_POST['is_visible'];

    $sql = "UPDATE sections SET is_visible = :is_visible WHERE section_name = :section_name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':is_visible' => $isVisible,
        ':section_name' => $sectionName,
    ]);
}
