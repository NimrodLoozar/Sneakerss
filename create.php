<?php
include 'config/config.php';

function validate_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    // Validate and sanitize inputs
    $firstname = validate_input(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $lastname = validate_input(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $phonenumber = validate_input(filter_input(INPUT_POST, 'phonenumber', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $email = validate_input(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $question = validate_input(filter_input(INPUT_POST, 'question', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    // Check for empty fields
    if (empty($firstname)) $errors[] = "Voornaam is verplicht.";
    if (empty($lastname)) $errors[] = "Achternaam is verplicht.";
    if (empty($email)) $errors[] = "E-mail is verplicht.";
    if (empty($question)) $errors[] = "Vraag is verplicht.";

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Ongeldig e-mailadres.";
    }

    // Validate phone number (simple check, can be improved)
    if (!empty($phonenumber) && !preg_match("/^[0-9]{10}$/", $phonenumber)) {
        $errors[] = "Ongeldig telefoonnummer.";
    }

    // If no errors, process the form
    if (empty($errors)) {
        try {
            $sql = "INSERT INTO contact (Firstname, Lastname, PhoneNumber, Email, Question)
                    VALUES (:firstname, :lastname, :phonenumber, :email, :question)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':phonenumber' => $phonenumber,
                ':email' => $email,
                ':question' => $question
            ]);
            $feedback = "We hebben uw formulier ontvangen. We nemen zo snel mogelijk contact met u op!";
            header('Refresh:2.5; url=index.html');
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            $errors[] = "Er is een fout opgetreden bij het verwerken van uw aanvraag. Probeer het later opnieuw.";
        }
    }
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
    <div class="container">
        <?php if (isset($feedback)): ?>
            <h3><?php echo htmlspecialchars($feedback); ?></h3>
        <?php elseif (!empty($errors)): ?>
            <h3>Er zijn fouten opgetreden:</h3>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <h3>Vul het formulier in om contact met ons op te nemen.</h3>
        <?php endif; ?>
    </div>
</body>

</html>