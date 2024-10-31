<?php
session_start();
require_once 'config/config.php'; // Verbind met de database

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Controleer of het event_id is doorgegeven
if (!isset($_GET['event_id'])) {
    header('Location: dashboard.php');
    exit();
}

$event_id = $_GET['event_id'];

// Haal evenementgegevens op
$query = "SELECT * FROM events WHERE id = :event_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
$stmt->execute();
$event = $stmt->fetch(PDO::FETCH_ASSOC);

// Haal alle pleinen op
$query = "SELECT * FROM plains WHERE event_id = :event_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
$stmt->execute();
$plains = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Stand Reserveren voor <?php echo htmlspecialchars($event['name']); ?></title>
    <script>
        function getStands(plain_id) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_stands.php?plain_id=" + plain_id, true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    document.getElementById('stand_select').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        function updatePrice() {
            var standSelect = document.getElementById("stand_select");
            var daysSelect = document.getElementById("days");
            var priceDisplay = document.getElementById("price_display");

            var standPrice = standSelect.options[standSelect.selectedIndex].dataset.price;
            var days = daysSelect.value;

            if (standPrice) {
                var totalPrice = standPrice * days;
                priceDisplay.textContent = "Prijs: €" + totalPrice;
            } else {
                priceDisplay.textContent = "Selecteer een stand en aantal dagen";
            }
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="text"]:focus,
        select:focus {
            border-color: #007BFF;
            outline: none;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        p.error {
            color: red;
            text-align: center;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Reserveer een stand voor <?php echo htmlspecialchars($event['name']); ?></h1>

    <form action="reserve_stands.php?event_id=<?php echo $event_id; ?>" method="POST">
        <label for="company_name">Bedrijfsnaam:</label>
        <input type="text" name="company_name" id="company_name" required>

        <label for="plain">Kies een plein:</label>
        <select name="plain_id" id="plain" onchange="getStands(this.value)" required>
            <option value="">-- Selecteer een plein --</option>
            <?php foreach ($plains as $plain): ?>
                <option value="<?php echo $plain['id']; ?>">
                    <?php echo htmlspecialchars($plain['plain_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="stand_id">Kies een stand:</label>
        <select name="stand_id" id="stand_select" onchange="updatePrice()" required>
            <option value="">-- Selecteer eerst een plein --</option>
        </select>

        <label for="days">Aantal dagen:</label>
        <select name="days" id="days" onchange="updatePrice()" required>
            <option value="1">1 dag</option>
            <option value="2">2 dagen</option>
        </select>

        <p id="price_display">Selecteer een stand en aantal dagen</p>

        <button type="submit">Reserveer Stand</button>
    </form>
    <a href="dashboard.php">Terug naar het Dashboard</a>
</body>

</html>