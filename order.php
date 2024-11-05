<!-- order.php -->
<?php
session_start(); // Start de sessie

// Zorg ervoor dat je de juiste configuratie laadt
include 'config/config.php'; // Dit moet het juiste pad zijn naar je config bestand

// Ticketinformatie ophalen uit URL
$ticket_type = isset($_GET['ticket_type']) ? $_GET['ticket_type'] : 'Ticket';
$price_per_ticket = isset($_GET['price']) ? (float)$_GET['price'] : 0.00;

// Ophalen van evenementen uit de database
$sql = "SELECT * FROM events"; // Pas dit aan naar jouw tabel en kolomnamen
$stmt = $pdo->prepare($sql);
$stmt->execute();
$evenementen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestel Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function updateTotal() {
            const quantity = document.getElementById('quantity').value;
            const pricePerTicket = <?php echo $price_per_ticket; ?>;
            const total = quantity * pricePerTicket;
            document.getElementById('totalPrice').innerText = '€' + total.toFixed(2);
        }
    </script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-2xl font-bold mb-6">Bestel je tickets voor <?php echo htmlspecialchars($ticket_type); ?></h1>

        <form action="invoice.php" method="POST" class="bg-white p-6 rounded shadow-md">

            <!-- Evenement Selectie -->
            <label class="block text-lg font-semibold mb-2">Kies evenement:</label>
            <select name="event" class="w-full p-2 border rounded mb-4" required>
                <?php foreach ($evenementen as $evenement): ?>
                    <option value="<?php echo $evenement['id']; ?>">
                        <?php echo htmlspecialchars($evenement['name'] . ' - ' . $evenement['start_date'] . ' tot ' . $evenement['end_date']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Aantal Tickets -->
            <label class="block text-lg font-semibold mb-2">Aantal tickets:</label>
            <input type="number" id="quantity" name="quantity" min="1" value="1" class="w-full p-2 border rounded mb-4" oninput="updateTotal()" required>

            <!-- Prijs Informatie -->
            <p class="text-lg mb-4">Prijs per ticket: €<?php echo number_format($price_per_ticket, 2); ?></p>
            <p class="text-xl font-bold mb-6">Totale prijs: <span id="totalPrice">€<?php echo number_format($price_per_ticket, 2); ?></span></p>

            <!-- Verborgen Velden om Informatie door te sturen -->
            <input type="hidden" name="ticket_type" value="<?php echo htmlspecialchars($ticket_type); ?>">
            <input type="hidden" name="price_per_ticket" value="<?php echo $price_per_ticket; ?>">

            <!-- Bestel Knop -->
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">Verder</button>
            <a href="/dashboard" type="button" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 transition">Terug</a>

        </form>
    </div>
</body>

</html>