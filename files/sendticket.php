<?php
require('fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Flight Details Table', 0, 1, 'C');
$pdf->Ln(5); // line break

// Set column headers
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(0, 102, 204);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(40, 10, 'Flight', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'From', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'To', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Departure', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Status', 1, 1, 'C', true); // 1 = move to next line

// Table rows
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0);
$data = [
    ['AI2025', 'Mumbai', 'Delhi', '10:30 AM', 'On Time'],
    ['AI2040', 'Delhi', 'Chennai', '12:00 PM', 'Delayed'],
    ['AI2055', 'Pune', 'Bangalore', '02:45 PM', 'On Time']
];

foreach ($data as $row) {
    foreach ($row as $col) {
        $pdf->Cell(40, 10, $col, 1, 0, 'C');
    }
    $pdf->Ln();
}

$pdf->Output();
?>
