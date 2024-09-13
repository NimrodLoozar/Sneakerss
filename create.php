<?php
include('../config/config.php');

/**
 * Gebruik dubbele quotes om de connectiestring, 
 * gebruik kleine letters voor host en dbname!
 */
$dsn = "mysql:host=$dbHost;
        dbname=$dbName;
        charset=UTF8";

/**
 * Maak een nieuw PDO object waarmee je verbinding maakt met de 
 * MySQL-server en de database
 */
$pdo = new PDO($dsn, $dbUser, $dbPass);

/**
 * We gaan de $_POST-array waarden schoonmaken
 */
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Prepare the query
    $sql = "INSERT INTO contact (Firstname, 
                                Lastname,
                                PhoneNumber, 
                                Email, 
                                Question)           
            VALUEs              (:firstname, 
                                :lastname, 
                                :phonenumber,
                                :email, 
                                :question)";
    $statement = $pdo->prepare($sql);

    // Bind the parameters
    $statement->bindParam(':firstname', $_POST['firstname'], PDO::PARAM_STR);
    $statement->bindParam(':lastname', $_POST['lastname'], PDO::PARAM_STR);
    $statement->bindParam(':phonenumber', $_POST['phonenumber'], PDO::PARAM_STR);
    $statement->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
    $statement->bindParam(':question', $_POST['question'], PDO::PARAM_STR);
    
 /**
     * Voer de query uit in de database
     */
    $statement->execute();

    /**
     * Geef feedback aan de gebruiker
     */
    

    /**
     * Met een header() functie kun je automatisch naar een andere pagina
     * navigeren
     */
    header('Refresh:2.5; url=../index.php');
    ?>


<!DOCTYPE html>
<html lang="en">
<head lang="en">
    <meta charset="UTF-8">

    <!--Page Title-->
    <title>Sneakerss - 2024</title>

    <!--Meta Keywords and Description-->
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />

    <!--Favicon-->
    <link rel="shortcut icon" href="assets/img/favicon.ico" title="Favicon" />

    <!-- Main CSS Files -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Namari Color CSS -->
    <link rel="stylesheet" href="assets/css/namari-color.css">

    <!--Icon Fonts - Font Awesome Icons-->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!-- Animate CSS-->
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css">

    <!--Google Webfonts-->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
</head>
<body>
    <h3>We hebben uw formulier ontvangen. <br> We nemen zo snel mogelijk contact met u op!</h3>
</body>
</html>


    


