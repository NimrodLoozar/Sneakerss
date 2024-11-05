<!-- invoice.php -->
<?php
include 'config/config.php';
session_start();

// Informatie ophalen uit POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['ticket_type'] = $_POST['ticket_type'];
    $_SESSION['price_per_ticket'] = $_POST['price_per_ticket'];
    $_SESSION['quantity'] = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
}

// Informatie ophalen uit de sessie met controles
$ticket_type = isset($_SESSION['ticket_type']) ? $_SESSION['ticket_type'] : 'Onbekend';
$price_per_ticket = isset($_SESSION['price_per_ticket']) ? $_SESSION['price_per_ticket'] : 0;
$quantity = isset($_SESSION['quantity']) ? $_SESSION['quantity'] : 0;
$total_price = $quantity * $price_per_ticket;
?>


<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factuur</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <h1 class="text-2xl font-bold mb-6">Factuur voor <?php echo htmlspecialchars($ticket_type); ?></h1>
        <p class="text-lg mb-4">Tickettype: <?php echo htmlspecialchars($ticket_type); ?></p>
        <p class="text-lg mb-4">Prijs per ticket: €<?php echo number_format($price_per_ticket, 2); ?></p>
        <p class="text-lg mb-4">Aantal tickets: <?php echo $quantity; ?></p>
        <p class="text-xl font-bold mb-6">Totale prijs: €<?php echo number_format($total_price, 2); ?></p>

        <form action="confirm_order.php" method="POST">
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">Bestellen</button>
        </form>
    </div>
</body>

</html>