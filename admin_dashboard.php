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
    <?php if (empty($allreservations)): ?>
        <p>Geen nieuwe reserveringen.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($allreservations as $reservation): ?>
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

    <h2>Beheer Secties</h2>
    <?php
    $sql = "SELECT id, section_name, is_visible FROM sections";
    $stmt = $pdo->query($sql);
    $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <ul>
        <?php foreach ($sections as $section): ?>
            <li>
                <?php echo htmlspecialchars($section['section_name']); ?>
                <label class="switch">
                    <input type="checkbox" class="toggle-visibility" data-id="<?php echo $section['id']; ?>"
                        <?php echo $section['is_visible'] ? 'checked' : ''; ?>>
                    <span class="slider"></span>
                </label>
            </li>
        <?php endforeach; ?>
    </ul>

    <script>
        document.querySelectorAll('.toggle-visibility').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const sectionId = this.getAttribute('data-id');
                const isVisible = this.checked ? 1 : 0;

                fetch('toggle_section_visibility.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'section_id': sectionId,
                        'is_visible': isVisible
                    })
                }).then(response => response.json()).then(data => {
                    // Handle response if needed
                });
            });
        });
    </script>

    <style>
        /* Stijling voor de schuifknop */
        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:checked+.slider:before {
            transform: translateX(20px);
        }
    </style>



    <ul>
        <li><a href="logout.php">Uitloggen</a></li>
        <li><a href="/">Home</a></li>
        <li><a href="/dashboard">Dashboard</a></li>
    </ul>
</body>

</html>