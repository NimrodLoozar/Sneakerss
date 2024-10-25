<?php
session_start();
include 'config/config.php';

// Controleer of de gebruiker is ingelogd en admin is
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header('Location: login.php');
    exit();
}


// Haal alle reserveringen op die nog niet zijn verwerkt
$sql = "SELECT r.id, r.company_name, s.stand_number, p.plain_name, r.statuses FROM reservations r
        JOIN stands s ON r.stand_id = s.id
        JOIN plains p ON s.plain_id = p.id
        WHERE r.statuses = 'active'";
$stmt = $pdo->query($sql);
$allreservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
        }

        h2 {
            color: #666;
            margin-top: 20px;
        }

        form {
            background: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #218838;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .reservation-list {
            list-style-type: none;
            padding: 0;
        }

        .reservation-item {
            background: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }

        .reservation-actions {
            display: inline;
        }

        .reservation-actions button {
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <h1>Admin Dashboard</h1>

    <h2>Nieuwe Reserveringen</h2>
    <?php if (empty($reservations)): ?>
        <p>Geen nieuwe reserveringen.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($reservations as $reservation): ?>
                <li>
                    <?php echo htmlspecialchars($reservation['company_name']) . " - Stand: " . htmlspecialchars($reservation['stand_number']) . " op plein " . htmlspecialchars($reservation['plain_name']); ?>
                    <form action="process_reservation.php" method="POST" style="display:inline;">
                        <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                        <button type="submit" name="action" value="approve">Goedkeuren</button>
                        <button type="submit" name="action" value="reject">Afkeuren</button>
                    </form>
                </li>
            <?php endforeach; ?>

        </ul>
    <?php endif; ?>

    <ul>
        <li><a href="logout.php">Uitloggen</a></li>
        <li><a href="/">Home</a></li>
        <li><a href="/dashboard">Dashboard</a></li>
    </ul>
</body>

</html>