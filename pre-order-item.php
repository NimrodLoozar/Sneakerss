<?php
session_start();
include 'config/config.php';

// Controleer of de sneaker is opgegeven
if (isset($_GET['sneaker'])) {
    $sneakerName = htmlspecialchars($_GET['sneaker']);
} else {
    die("Geen sneaker geselecteerd om te pre-orderen.");
}

// Genereer een willekeurige prijs tussen 200 en 400 euro
$price = rand(200, 400);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pre-order - <?php echo $sneakerName; ?></title>
</head>

<body>
    <h2>Pre-order voor: <?php echo $sneakerName; ?></h2>
    <p>Prijs: €<?php echo $price; ?></p>

    <form action="process-preorder.php" method="post">
        <input type="hidden" name="sneaker" value="<?php echo $sneakerName; ?>">
        <input type="hidden" name="price" value="<?php echo $price; ?>">

        <label for="name">Naam:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>

        <button type="submit">Plaats Pre-order</button>
    </form>
</body>

</html>