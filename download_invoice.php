<!-- download_invoice.php -->
<?php
ob_start(); // Start output buffering

require('vendor/setasign/fpdf/fpdf.php'); // Het pad naar je fpdf.php bestand

session_start(); // Start de sessie om de gegevens te gebruiken die je in invoice.php hebt opgeslagen

// Ophalen van de gegevens uit de sessie
$ticket_type = isset($_SESSION['ticket_type']) ? $_SESSION['ticket_type'] : 'Onbekend';
$price_per_ticket = isset($_SESSION['price_per_ticket']) ? $_SESSION['price_per_ticket'] : 0;
$quantity = isset($_SESSION['quantity']) ? $_SESSION['quantity'] : 0;
$total_price = $quantity * $price_per_ticket;

// Haal het order_id op uit de URL querystring (bijvoorbeeld ?order_id=123)
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : 'Onbekend'; // Zorg ervoor dat order_id bestaat, of geef een fallback-waarde

// PDF genereren
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Titel van de factuur
$pdf->Cell(0, 10, "Factuur voor Bestelling #$order_id", 0, 1, 'C');
$pdf->Ln(10);

// Ticketgegevens
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "Tickettype: " . htmlspecialchars($ticket_type), 0, 1);
$pdf->Cell(0, 10, "Prijs per ticket: €" . number_format($price_per_ticket, 2), 0, 1);
$pdf->Cell(0, 10, "Aantal tickets: " . $quantity, 0, 1);
$pdf->Ln(10);

// Totale prijs
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, "Totale prijs: €" . number_format($total_price, 2), 0, 1, 'C');

// Genereer de PDF en start de download
$pdf->Output('D', "Factuur_$order_id.pdf"); // De factuur wordt gedownload als PDF met de naam "Factuur_{order_id}.pdf"

ob_end_flush(); // Verzendt de output naar de browser na de PDF
