<?php
include 'config/config.php';

// We gebruiken nu de variabelen uit config.php
try {
    // De $pdo-verbinding is al gemaakt in config.php, dus we hoeven dit niet opnieuw te doen

    // Controleer of het formulier is verzonden
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize de input
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $phonenumber = filter_input(INPUT_POST, 'phonenumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $question = filter_input(INPUT_POST, 'question', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Prepare the query
        $sql = "INSERT INTO contact (Firstname, Lastname, PhoneNumber, Email, Question)
                VALUES (:firstname, :lastname, :phonenumber, :email, :question)";
        $statement = $pdo->prepare($sql);

        // Bind the parameters
        $statement->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $statement->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $statement->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':question', $question, PDO::PARAM_STR);

        // Voer de query uit in de database
        $statement->execute();

        // Geef feedback aan de gebruiker
        $feedback = "We hebben uw formulier ontvangen. We nemen zo snel mogelijk contact met u op!";

        // Met een header() functie kun je automatisch naar een andere pagina navigeren
        header('Refresh:2.5; url=index.html');
    }
} catch (PDOException $e) {
    die("Fout bij het verwerken van het formulier: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Sneakerss - 2024</title>
    <link rel="stylesheet" href="assets/css/create.css">
</head>
<body>
    <?php if (isset($feedback)): ?>
        <h3><?php echo $feedback; ?></h3>
    <?php else: ?>
        <div class="container">
            <h3>Vul het formulier in om contact met ons op te nemen.</h3>
        </div>
    <?php endif; ?>
</body>
</html>