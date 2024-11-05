<?php
// config.php (database connectie)
$host = 'localhost';
$dbname = 'event_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fout bij verbinding: " . $e->getMessage());
}

// Pas het pad aan naar PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $type = $_POST['type'];
    $bedrag = $_POST['bedrag'];
    $factuurNummer = rand(1000, 9999);
    $datum = date("Y-m-d");

    // PDF genereren
    class PDF extends FPDF
    {
        function Header()
        {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Factuur', 0, 1, 'C');
            $this->Ln(10);
        }

        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }
    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, "Factuurnummer: $factuurNummer", 0, 1);
    $pdf->Cell(0, 10, "Datum: $datum", 0, 1);
    $pdf->Cell(0, 10, "Naam: $naam", 0, 1);
    $pdf->Cell(0, 10, "E-mail: $email", 0, 1);
    $pdf->Cell(0, 10, "Type: $type", 0, 1);
    $pdf->Cell(0, 10, "Bedrag: € $bedrag", 0, 1);

    $pdf->Ln(10);
    $pdf->Cell(0, 10, "Bedankt voor uw betaling!", 0, 1, 'C');

    // Sla PDF tijdelijk op
    $filePath = "facturen/Factuur_$factuurNummer.pdf";
    $pdf->Output("F", $filePath);

    // E-mail versturen met PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server instellingen (gebruik je eigen SMTP-configuratie)
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';  // Vervang met je eigen SMTP-server
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@example.com';  // SMTP-gebruikersnaam
        $mail->Password = 'your-password';           // SMTP-wachtwoord
        $mail->SMTPSecure = 'tls';                   // TLS of SSL
        $mail->Port = 587;                           // Poortnummer (587 voor TLS, 465 voor SSL)

        // Ontvanger en verzender instellingen
        $mail->setFrom('no-reply@example.com', 'Factuur Service');
        $mail->addAddress($email, $naam);  // Voeg het e-mailadres van de ontvanger toe

        // Bijlage
        $mail->addAttachment($filePath, "Factuur_$factuurNummer.pdf");

        // E-mail inhoud
        $mail->isHTML(true);
        $mail->Subject = 'Uw factuur voor ticketaankoop of standhuur';
        $mail->Body    = "
            <h3>Beste $naam,</h3>
            <p>Bedankt voor uw aankoop. In de bijlage vindt u uw factuur (Factuurnummer: $factuurNummer).</p>
            <p>Met vriendelijke groeten,<br>Het factuurteam</p>
        ";
        $mail->AltBody = "Beste $naam,\n\nBedankt voor uw aankoop. In de bijlage vindt u uw factuur (Factuurnummer: $factuurNummer).\n\nMet vriendelijke groeten,\nHet factuurteam";

        // Verstuur de e-mail
        $mail->send();
        echo "De factuur is succesvol verstuurd naar $email.";

        // Verwijder het tijdelijke bestand
        unlink($filePath);
    } catch (Exception $e) {
        echo "Er is een fout opgetreden bij het verzenden van de e-mail: {$mail->ErrorInfo}";
    }
}
