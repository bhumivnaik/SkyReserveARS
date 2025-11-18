<?php
require('fpdf.php');

class PDF extends FPDF {
    function RoundedRect($x, $y, $w, $h, $r, $style = '') {
        $k = $this->k;
        $hp = $this->h;
        $op = $style=='F' ? 'f' : ($style=='FD' || $style=='DF' ? 'b' : 'S');
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m', ($x+$r)*$k, ($hp-$y)*$k ));
        $xc = $x+$w-$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k, ($hp-$y)*$k ));
        $this->_Arc($xc+$r*$MyArc, $yc-$r, $xc+$r, $yc-$r*$MyArc, $xc+$r, $yc);
        $xc = $x+$w-$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l', ($x+$w)*$k, ($hp-$yc)*$k ));
        $this->_Arc($xc+$r, $yc+$r*$MyArc, $xc+$r*$MyArc, $yc+$r, $xc, $yc+$r);
        $xc = $x+$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k, ($hp-($y+$h))*$k ));
        $this->_Arc($xc-$r*$MyArc, $yc+$r, $xc-$r, $yc+$r*$MyArc, $xc-$r, $yc);
        $xc = $x+$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $x*$k, ($hp-$yc)*$k ));
        $this->_Arc($xc-$r, $yc-$r*$MyArc, $xc-$r*$MyArc, $yc-$r, $xc, $yc-$r);
        $this->_out($op);
    }
    function _Arc($x1, $y1, $x2, $y2, $x3, $y3) {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ',
            $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k,
            $x3*$this->k, ($h-$y3)*$this->k));
    }
}

$pdf = new PDF('P', 'mm', 'A4'); // Portrait A4
$pdf->AddPage();

// Background
$pdf->SetFillColor(240, 247, 255);
$pdf->RoundedRect(10, 10, 190, 277, 6, 'F');

// Header
$pdf->SetFillColor(0, 102, 204);
$pdf->RoundedRect(10, 10, 190, 30, 6, 'F');
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 20);
$pdf->SetXY(45, 18);
$pdf->Cell(0, 10, 'SKYLINE AIRWAYS', 0, 0, 'L');

// Section 1: Passenger Info
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(255, 255, 255);
$pdf->RoundedRect(15, 50, 180, 35, 4, 'F');

$pdf->SetFont('Arial', 'B', 14);
$pdf->SetXY(20, 53);
$pdf->Cell(0, 8, 'Passenger Details', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->SetXY(20, 61);
$pdf->Cell(40, 8, 'Name:', 0, 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 8, 'Bhumi Naik', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->SetXY(20, 69);
$pdf->Cell(40, 8, 'Class:', 0, 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 8, 'Business', 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 8, 'Seat No:', 0, 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, '14A', 0, 1);

// Section 2: Flight Info
$pdf->SetFillColor(255, 255, 255);
$pdf->RoundedRect(15, 95, 180, 50, 4, 'F');
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetXY(20, 98);
$pdf->Cell(0, 8, 'Flight Details', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->SetXY(20, 106);
$pdf->Cell(25, 8, 'Flight:', 0, 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(35, 8, 'AI2025', 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(15, 8, 'From:', 0, 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 8, 'Mumbai', 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(10, 8, 'To:', 0, 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, 'Delhi', 0, 1);

$pdf->SetFont('Arial', '', 12);
$pdf->SetXY(20, 116);
$pdf->Cell(40, 8, 'Departure:', 0, 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 8, '10:30 AM, 12 Nov 2025', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->SetXY(20, 124);
$pdf->Cell(40, 8, 'Arrival:', 0, 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 8, '12:50 PM', 0, 1);

// Section 3: Payment Info
$pdf->SetFillColor(255, 255, 255);
$pdf->RoundedRect(15, 155, 180, 40, 4, 'F');
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetXY(20, 158);
$pdf->Cell(0, 8, 'Payment Details', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->SetXY(20, 167);
$pdf->Cell(60, 8, 'Booking ID: BID001', 0, 1);
$pdf->SetXY(20, 175);
$pdf->Cell(60, 8, 'Payment ID: PID001', 0, 1);
$pdf->SetXY(20, 183);
$pdf->Cell(60, 8, 'Mode: UPI', 0, 0);
$pdf->SetXY(100, 183);
$pdf->Cell(60, 8, 'Amount: ₹5500', 0, 1);

// QR code

// Footer message
$pdf->SetTextColor(100, 100, 100);
$pdf->SetFont('Arial', 'I', 10);
$pdf->SetXY(15, 265);
$pdf->Cell(0, 10, 'Thank you for flying with Skyline Airways ✈', 0, 0, 'C');

// Border
$pdf->SetDrawColor(0, 102, 204);
$pdf->RoundedRect(10, 10, 190, 277, 6, 'D');

// Output
$pdf->Output('I', 'Vertical_Ticket.pdf');
?>
