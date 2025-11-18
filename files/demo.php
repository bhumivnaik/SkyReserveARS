<?php
require('fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 12);

$pdf->SetFillColor(20, 40, 220);   // Deep royal blue border box
$pdf->SetFillColor(230, 240, 255); // Background (light blue)220, 230, 255
$pdf->Rect(10, 10, 190, 277, 'DF'); // x=10, y=20, width=190, height=60
$pdf->SetFillColor(40, 80, 250);
$pdf->Rect(10, 5, 190, 28, 'DF');
$pdf->SetXY(14, 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(50, 10, 'E-Ticket', 0, 1);
$pdf->SetXY(14, 20);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 10, "Booking ID: $booking_id", 0, 1);

$pdf->SetFont('Arial', 'B', 22);
$pdf->Image('plane.png', $pdf->SetXY(182, 20), 15, 15);
$pdf->SetXY(130, 14);
$pdf->Cell(50, 10, 'SKYRESERVE', 0, 1);

$pdf->Ln(10); //line break
$pdf->SetFont('Times', 'BI', 13);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetX(14);
$pdf->Cell(50, 10, 'Passenger Details', 0, 1);
$pdf->SetFillColor(255, 255, 255);
$pdf->Rect(16, 45, 178, 40, 'F');
$pdf->SetFont('Times', '', 11);
$pdf->SetX(16);
$pdf->Cell(45, 10, "Passenger Name     :  $fnames[$index].' '.$mnames[$index].' '.$lnames[$index]", 0, 1);
$pdf->SetX(16);
$pdf->Cell(45, 10, "Passenger Email     :  $emails[$index]", 0, 1);
$pdf->SetX(16);
$pdf->Cell(45, 10, "Passenger Ph.No    :  $phones[$index]", 0, 1);
$pdf->SetX(16);
$pdf->Cell(45, 10, "Passenger Age        :  $ages[$index]", 0, 1);

$pdf->Ln(10);
$pdf->SetX(14);
$pdf->SetFont('Times', 'BI', 13);
$pdf->Cell(50, 10, 'Flight Details', 0, 1);
$pdf->SetFillColor(255, 255, 255);
$pdf->Rect(16, 105, 178, 65, 'F');
$pdf->SetFont('Times', '', 11);
$pdf->SetX(16);
$pdf->Cell(40, 15, "Flight Name       : $flight_name", 0, 0);
$pdf->Cell(49, 15, "", 0, 0);
$pdf->Cell(40, 15, "Date   : $date", 0, 0);
$pdf->Cell(49, 15, "", 0, 1);

$pdf->SetX(16);
$pdf->Cell(40, 10, "From                   : $source_full", 0, 1);
$pdf->SetX(16);
$pdf->Cell(40, 10, "To                       : $dest_full", 0, 1);

$pdf->SetX(16);
$pdf->Cell(40, 10, "Departure Time  : $dep_time", 0, 1);
$pdf->SetX(16);
$pdf->Cell(40, 10, "Arrival Time      : $arr_time", 0, 1);
$pdf->SetX(16);
$pdf->Cell(40, 10, "Class                  : $class_name", 0, 0);


$pdf->SetX(16);

$pdf->Ln(20);
$pdf->SetX(14);
$pdf->SetFont('Times', 'BI', 13);
$pdf->Cell(50, 10, 'Payment Details', 0, 1);
$pdf->SetFillColor(255, 255, 255);
$pdf->Rect(16, 190, 178, 40, 'F');
$pdf->SetFont('Times', '', 11);
$pdf->SetX(16);
$pdf->Cell(40, 10, "Booking ID    : $booking_id", 0, 1);

$pdf->SetX(16);
$pdf->Cell(40, 10, "Payment ID    : $pay_id", 0, 1);
$pdf->SetX(16);
$pdf->Cell(40, 10, "Mode              : $mode", 0, 1);
$pdf->SetX(16);
$pdf->Cell(40, 10, "Amount          : $total", 0, 1);

$pdf->Ln(5);
$pdf->SetX(16);
$pdf->Cell(100, 6, 'Instructions:', 0, 1);
$pdf->SetX(16);
$pdf->Cell(100, 5, '- Please carry a valid ID proof (Passport/Aadhaar/PAN).', 0, 1);
$pdf->SetX(16);
$pdf->Cell(100, 5, '- Arrive at least 2 hours before departure.', 0, 1);
$pdf->SetX(16);
$pdf->Cell(100, 5, '- For any queries, contact skyreserve@airline.com', 0, 1);

$pdf->SetTextColor(100, 100, 100);
$pdf->SetFont('Arial', 'I', 10);
$pdf->SetXY(15, 265);
$pdf->Cell(0, 10, 'Thank you for choosing SkyReserve! Have a Safe Journey.', 0, 0, 'C');

$pdf->Output();
