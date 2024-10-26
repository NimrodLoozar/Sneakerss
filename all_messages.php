<?php
session_start();
require_once 'config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

try {
    // Haal alle berichten van de ingelogde gebruiker op
    $query = "SELECT id, subject, content, is_read, created_at FROM messages WHERE user_id = :user_id ORDER BY created_at DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = "Er is een fout opgetreden: " . $e->getMessage();
    $messages = [];
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>Alle Berichten</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Uw Berichten</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <p class="success"><?= $_SESSION['message'] ?></p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <p class="error"><?= $_SESSION['error'] ?></p>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (empty($messages)): ?>
        <p>U heeft geen berichten.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Onderwerp</th>
                    <th>Inhoud</th>
                    <th>Status</th>
                    <th>Datum</th>
                    <th>Actie</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>
                    <tr>
                        <td><?= htmlspecialchars($message['subject']) ?></td>
                        <td><?= htmlspecialchars($message['content']) ?></td>
                        <td><?= $message['is_read'] ? 'Gelezen' : 'Ongelezen' ?></td>
                        <td><?= htmlspecialchars($message['created_at']) ?></td>
                        <td>
                            <?php if (!$message['is_read']): ?>
                                <form action="mark_message_read.php" method="POST">
                                    <input type="hidden" name="message_id" value="<?= $message['id'] ?>">
                                    <button type="submit">Markeer als gelezen</button>
                                </form>
                            <?php else: ?>
                                <span>Gelezen</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>

</html>