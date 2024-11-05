<!-- process_order.php -->

<?php
// Bestelinformatie ophalen
$event = $_POST['event'];
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
$ticket_type = $_POST['ticket_type'];
$price_per_ticket = (float)$_POST['price_per_ticket'];
$total_price = $quantity * $price_per_ticket;

// Opslaan van bestelling (Hier voeg je database-opslag toe indien nodig)

// Orderbevestiging weergeven
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orderbevestiging</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-2xl font-bold mb-6">Orderbevestiging</h1>
        <p class="text-lg mb-4">Bedankt voor je bestelling van <strong><?php echo htmlspecialchars($quantity); ?></strong> tickets voor <strong><?php echo htmlspecialchars($ticket_type); ?></strong>.</p>
        <p class="text-lg mb-4">Evenement: <?php echo ($event == 1) ? 'Sneakerness Van Nelle Fabriek' : 'Sneakerness Millenáris Budapest'; ?></p>
        <p class="text-lg mb-4">Totale prijs: <strong>€<?php echo number_format($total_price, 2); ?></strong></p>
    </div>
</body>

</html>