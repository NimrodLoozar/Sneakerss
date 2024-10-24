<?php
session_start();
require_once 'config/config.php'; // Verbind met je database

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

// Haal het geselecteerde evenement op
$query = "SELECT * FROM events WHERE id = :event_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
$stmt->execute();
$event = $stmt->fetch(PDO::FETCH_ASSOC);

// Haal alle pleinen voor het evenement op
$query = "SELECT * FROM plains WHERE event_id = :event_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
$stmt->execute();
$plains = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verwerk het reserveringsformulier
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $company_name = $_POST['company_name'];
    $stand_id = $_POST['stand_id'];

    // Controleer of de gekozen stand nog beschikbaar is
    $query = "SELECT * FROM stands WHERE id = :stand_id AND is_available = TRUE";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':stand_id', $stand_id, PDO::PARAM_INT);
    $stmt->execute();
    $stand = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stand) {
        // Reserveer de stand
        $query = "INSERT INTO reservations (user_id, stand_id, company_name) VALUES (:user_id, :stand_id, :company_name)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':stand_id', $stand_id, PDO::PARAM_INT);
        $stmt->bindParam(':company_name', $company_name, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Update stand beschikbaarheid
            $query = "UPDATE stands SET is_available = FALSE WHERE id = :stand_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':stand_id', $stand_id, PDO::PARAM_INT);
            $stmt->execute();

            // Redirect naar dashboard met succesbericht
            header('Location: dashboard.php?success=Stand succesvol gereserveerd!');
            exit();
        } else {
            $error = "Er is een fout opgetreden bij het reserveren van de stand.";
        }
    } else {
        $error = "De gekozen stand is niet meer beschikbaar. Kies een andere stand.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stand Huren voor <?php echo htmlspecialchars($event['name']); ?></title>
    <script>
        // Functie om de beschikbare stands per plein op te halen
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

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="reserve_stand.php?event_id=<?php echo $event_id; ?>" method="POST">
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

        <label for="stand_id">Kies een beschikbare stand:</label>
        <select name="stand_id" id="stand_select" required>
            <option value="">-- Selecteer eerst een plein --</option>
        </select>

        <button type="submit">Reserveer Stand</button>
    </form>

    <a href="dashboard.php">Terug naar het Dashboard</a>
</body>

</html>