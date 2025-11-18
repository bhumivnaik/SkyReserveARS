<?php
/*require("fpdf.php");

$pdf = new FPDF();
$pdf->AddPage();

// Header background
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(230, 240, 255);
$pdf->Rect(10, 10, 190, 277, 'F');

// Top blue bar
$pdf->SetFillColor(40, 80, 250);
$pdf->Rect(10, 5, 190, 28, 'F');

// Header Title
$pdf->SetXY(14, 12);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(50, 10, 'E-Ticket', 0, 1);

$pdf->SetXY(14, 20);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 10, "Booking ID: BID001", 0, 1);

$pdf->SetFont('Arial', 'B', 22);
$pdf->SetXY(130, 14);
$pdf->Cell(50, 10, 'SKYRESERVE', 0, 1);

// Passenger Details
$pdf->Ln(10);
$pdf->SetFont('Times', 'BI', 13);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetX(14);
$pdf->Cell(50, 10, 'Passenger Details', 0, 1);

$pdf->SetFillColor(255, 255, 255);
$pdf->Rect(16, 45, 178, 40, 'F');

$pdf->SetFont('Times', '', 11);
$pdf->SetX(16);
$pdf->Cell(45, 8, "Passenger Name :  John Doe", 0, 1);
$pdf->SetX(16);
$pdf->Cell(45, 8, "Passenger Email : johndoe@gmail.com", 0, 1);
$pdf->SetX(16);
$pdf->Cell(45, 8, "Passenger Ph.No : 9876543210", 0, 1);
$pdf->SetX(16);
$pdf->Cell(45, 8, "Passenger Age : 25", 0, 1);
$pdf->SetX(16);
$pdf->Cell(45, 8, "Trip Type : Round Trip", 0, 1);

// Outbound Flight Details
$pdf->Ln(10);
$pdf->SetX(14);
$pdf->SetFont('Times', 'BI', 13);
$pdf->Cell(50, 10, 'Outbound Flight Details', 0, 1);

$pdf->SetFillColor(255, 255, 255);
$pdf->Rect(16, 105, 178, 35, 'F');

$pdf->SetFont('Times', '', 11);
$pdf->SetX(16);
$pdf->Cell(40, 10, "Flight Name : AI202", 0, 0);
$pdf->Cell(49, 10, "", 0, 0);
$pdf->Cell(40, 10, "Date : 15-Jan-2025", 0, 1);

$pdf->SetX(16);
$pdf->Cell(40, 8, "From : Mumbai", 0, 0);
$pdf->Cell(49, 12, "", 0, 0);
$pdf->Cell(40, 8, "To : Delhi", 0, 1);
$pdf->SetX(16);
$pdf->Cell(40, 8, "Departure Time : 10:00 AM", 0, 0);
$pdf->Cell(49, 12, "", 0, 0);
$pdf->Cell(40, 8, "Arrival Time : 12:00 PM", 0, 1);
$pdf->SetX(16);
$pdf->Cell(40, 8, "Class : Economy", 0, 1);

// Return Flight Details
$pdf->Ln(10);
$pdf->SetX(14);
$pdf->SetFont('Times', 'BI', 13);
$pdf->Cell(50, 10, 'Return Flight Details', 0, 1);

$pdf->SetFillColor(255, 255, 255);
$pdf->Rect(16, 160, 178, 35, 'F');

$pdf->SetFont('Times', '', 11);
$pdf->SetX(16);
$pdf->Cell(40, 10, "Flight Name : AI203", 0, 0);
$pdf->Cell(49, 10, "", 0, 0);
$pdf->Cell(40, 10, "Date : 20-Jan-2025", 0, 1);

$pdf->SetX(16);
$pdf->Cell(40, 8, "From : Delhi", 0, 0);
$pdf->Cell(49, 8, "", 0, 0);
$pdf->Cell(40, 8, "To : Mumbai", 0, 1);
$pdf->SetX(16);
$pdf->Cell(40, 8, "Departure Time : 3:00 PM", 0, 0);
$pdf->Cell(49, 8, "", 0, 0);
$pdf->Cell(40, 8, "Arrival Time : 5:00 PM", 0, 1);
$pdf->SetX(16);
$pdf->Cell(40, 8, "Class : Economy", 0, 1);

// Payment Details
$pdf->Ln(10);
$pdf->SetX(14);
$pdf->SetFont('Times', 'BI', 13);
$pdf->Cell(50, 10, 'Payment Details', 0, 1);

$pdf->SetFillColor(255, 255, 255);
$pdf->Rect(16, 210, 178, 25, 'F');

$pdf->SetFont('Times', '', 11);
$pdf->SetX(16);
$pdf->Cell(40, 8, "Payment ID : PAY9001", 0, 1);
$pdf->SetX(16);
$pdf->Cell(40, 8, "Mode : UPI", 0, 1);
$pdf->SetX(16);
$pdf->Cell(40, 8, "Amount : ₹ 6,500", 0, 1);

$pdf->Ln(5);
$pdf->SetX(16);
$pdf->SetFont('Times', '', 10);
$pdf->Cell(100, 6, 'Instructions:', 0, 1);
$pdf->SetX(16);
$pdf->Cell(100, 5, '- Please carry a valid ID proof (Passport/Aadhaar/PAN).', 0, 1);
$pdf->SetX(16);
$pdf->Cell(100, 5, '- Arrive at least 2 hours before departure.', 0, 1);
$pdf->SetX(16);
$pdf->Cell(100, 5, '- For any queries, contact skyreserve@airline.com', 0, 1);


// Footer
$pdf->SetTextColor(100, 100, 100);
$pdf->SetFont('Arial', 'I', 10);
$pdf->SetXY(15, 266);
$pdf->Cell(0, 10, 'Thank you for choosing SkyReserve! Have a Safe Journey.', 0, 0, 'C');

// Output directly to browser
$pdf->Output();
*/
// -------------------------------
// CANCEL BOOKING BACKEND
// -------------------------------
$conn = new mysqli("localhost", "root", "", "airport");
if ($conn->connect_error) die("Connection Failed: " . $conn->connect_error);

$cancelMsg = "";
$err = "";

// When user submits cancellation form
if (isset($_POST['cancel_booking'])) {

    $booking_id = $_POST['booking_id'];
    $email = $_POST['email'];

    // 1. Validate booking
    $sql = "SELECT * FROM booking natural join makes natural join passenger WHERE booking_id=? AND email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $booking_id, $email);
    $stmt->execute();
    $booking = $stmt->get_result()->fetch_assoc();

    if (!$booking) {
        $err = "❌ Invalid Booking ID or Email!";
    } else {

        // Already cancelled?
        if ($booking['status'] == "cancelled") {
            $err = "⚠️ This booking is already cancelled!";
        } else {

            // Fetch booking details
            $trip_type = $booking['trip_type'];
            $qty = $booking['qty'];
            $out_flight_id = $booking['out_flight_id'];
            $ret_flight_id = $booking['ret_flight_id'];
            $out_date = $booking['out_date'];
            $ret_date = $booking['ret_date'];
            $payment_id = $booking['payment_id'];

            // 2. Cancel booking
            $u1 = $conn->prepare("UPDATE booking SET status='cancelled' WHERE booking_id=?");
            $u1->bind_param("s", $booking_id);
            $u1->execute();

            // 3. Cancel passengers
            $u2 = $conn->prepare("DELETE from passenger WHERE booking_id=?");
            $u2->bind_param("s", $booking_id);
            $u2->execute();

            // 4. Update payment (refund pending)
            $u3 = $conn->prepare("UPDATE payment SET refund_status='initiated' WHERE payment_id=?");
            $u3->bind_param("s", $payment_id);
            $u3->execute();

            // 5. Restore seats for outbound
            $s1 = $conn->prepare("UPDATE flightinstance SET seats = seats + ? WHERE flight_id=? AND date=?");
            $s1->bind_param("iss", $qty, $out_flight_id, $out_date);
            $s1->execute();

            // 6. Restore seats for return (only if two-way)
            if ($trip_type == "twoway") {
                $s2 = $conn->prepare("UPDATE flightinstance SET seats = seats + ? WHERE flight_id=? AND date=?");
                $s2->bind_param("iss", $qty, $ret_flight_id, $ret_date);
                $s2->execute();
            }

            $cancelMsg = "✔ Booking Cancelled Successfully!<br>
                          Booking ID: <b>$booking_id</b><br>
                          Refund Process Started for Payment ID: <b>$payment_id</b>";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Cancel Booking</title>
    <style>
        body {
            background: #f2f6ff;
            font-family: Arial;
        }

        .container {
            width: 450px;
            margin: 70px auto;
            padding: 25px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #2e5bff;
        }

        label {
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #2e5bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
        }

        .success {
            margin-top: 20px;
            background: #d4ffe0;
            padding: 15px;
            border-left: 4px solid green;
        }

        .error {
            margin-top: 20px;
            background: #ffd4d4;
            padding: 15px;
            border-left: 4px solid red;
        }
    </style>
</head>

<body>

    <div class="container">

        <h2>Cancel Booking</h2>

        <!-- Cancellation Form -->
        <form method="POST">
            <label>Booking ID</label>
            <input type="text" name="booking_id" required placeholder="Enter your Booking ID">

            <label>Email</label>
            <input type="email" name="email" required placeholder="Enter your Email used in booking">

            <button type="submit" name="cancel_booking">Cancel Booking</button>
        </form>

        <!-- Output messages -->
        <?php if ($cancelMsg): ?>
            <div class="success"><?= $cancelMsg ?></div>
        <?php endif; ?>

        <?php if ($err): ?>
            <div class="error"><?= $err ?></div>
        <?php endif; ?>

    </div>

</body>

</html>