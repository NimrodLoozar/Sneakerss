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
    <script src="https://cdn.tailwindcss.com"></script>
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
    <!-- <style>
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
    </style> -->
</head>

<body class="bg-gray-100 p-8">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">
        Reserveer een stand voor <?php echo htmlspecialchars($event['name']); ?>
    </h1>

    <form action="reserve_stands.php?event_id=<?php echo $event_id; ?>" method="POST" class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto space-y-6">
        <label for="company_name" class="block text-gray-700 font-semibold">Bedrijfsnaam:</label>
        <input type="text" name="company_name" id="company_name" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

        <label for="plain" class="block text-gray-700 font-semibold">Kies een plein:</label>
        <select name="plain_id" id="plain" onchange="getStands(this.value)" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">-- Selecteer een plein --</option>
            <?php foreach ($plains as $plain): ?>
                <option value="<?php echo $plain['id']; ?>">
                    <?php echo htmlspecialchars($plain['plain_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="stand_id" class="block text-gray-700 font-semibold">Kies een stand:</label>
        <select name="stand_id" id="stand_select" onchange="updatePrice()" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">-- Selecteer eerst een plein --</option>
        </select>

        <label for="days" class="block text-gray-700 font-semibold">Aantal dagen:</label>
        <select name="days" id="days" onchange="updatePrice()" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="1">1 dag</option>
            <option value="2">2 dagen</option>
        </select>

        <p id="price_display" class="text-gray-700 font-semibold">Selecteer een stand en aantal dagen</p>

        <label for="about" class="block text-gray-700 font-semibold">About:</label>
        <textarea name="about" id="about" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" rows="4"></textarea>

        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 transition-colors">Reserveer Stand</button>
    </form>

    <a href="dashboard.php" class="block text-center mt-6 text-blue-500 hover:underline">
        Terug naar het Dashboard
    </a>
</body>


</html>