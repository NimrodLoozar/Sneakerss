<!-- confirm_order.php -->
<?php
session_start(); // Zorg ervoor dat de sessie wordt gestart om gegevens op te halen

// Haal gegevens uit de sessie
$ticket_type = isset($_SESSION['ticket_type']) ? $_SESSION['ticket_type'] : 'Onbekend';
$price_per_ticket = isset($_SESSION['price_per_ticket']) ? $_SESSION['price_per_ticket'] : 0;
$quantity = isset($_SESSION['quantity']) ? $_SESSION['quantity'] : 0;
$total_price = $quantity * $price_per_ticket;

// Genereer een order_id voor de factuur (optioneel: opslaan in de database)
$order_id = uniqid('order_');

// Eventuele databaseoperaties voor het opslaan van de bestelling kunnen hier plaatsvinden
// Bijvoorbeeld, je kunt een bestelling toevoegen aan je database en het order_id ophalen.
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelling Succesvol</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-2xl font-bold mb-6">Bestelling Succesvol!</h1>
        <p class="text-lg mb-4">Bedankt voor je bestelling van <strong><?php echo htmlspecialchars($quantity); ?></strong> tickets voor <strong><?php echo htmlspecialchars($ticket_type); ?></strong>.</p>
        <p class="text-lg mb-4">Totale prijs: <strong>€<?php echo number_format($total_price, 2); ?></strong></p>
        <p class="text-lg mb-4">Je ontvangt binnenkort een e-mail met je factuur.</p>
        <a href="download_invoice.php?order_id=<?php echo $order_id; ?>" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition">Download Factuur</a>
        <a href="/dashboard" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">Naar Dashboard</a>
    </div>
</body>

</html>