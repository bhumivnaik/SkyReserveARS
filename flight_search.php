<?php
$server = "localhost";
$user = "root";
$password = "";
$dbname = "airport";

$conn = new mysqli($server, $user, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$source = $_POST['source'] ?? '';
$destination = $_POST['destination'] ?? '';
$trip = $_POST['trip'] ?? 'oneway';
$date = $_POST['date'] ?? '';
$return_date = $_POST['return_date'] ?? '';

// --- Function to build date condition dynamically ---
function buildDateCondition($dateField, $dateValue)
{
    return !empty($dateValue) ? "AND $dateField = '$dateValue'" : "";
}

// ⭐ ADDED FOR CHEAPEST CLASS
$selectedClass = $_POST['show_cheapest'] ?? '';
$cheapestResult = null;

if (!empty($selectedClass)) {
    $class_id = [
        "Economy" => 1001,
        "Business" => 1002,
        "First" => 1003
    ][$selectedClass];

    $sqlCheap = "
    SELECT 
        f.flight_id,
        f.flight_name,
        a1.city AS source_city,
        a2.city AS destination_city,
        priceTable.cheapest_price,
        fi.date, fi.departure_time, fi.arrival_time, fi.available_seats
    FROM (
        SELECT 
            p.flight_id,
            MIN(p.price) AS cheapest_price
        FROM price p
        JOIN flight f ON p.flight_id = f.flight_id
        JOIN airport a1 ON f.sourceAcode = a1.acode
        JOIN airport a2 ON f.destAcode = a2.acode
        JOIN flightinstance fi ON fi.flight_id = f.flight_id
        WHERE p.class_id = '$class_id'
          AND fi.date = '$date'
          AND (a1.city = '$source' OR a1.state = '$source' OR a1.country = '$source')
          AND (a2.city = '$destination' OR a2.state = '$destination' OR a2.country = '$destination')
        GROUP BY p.flight_id
        ORDER BY cheapest_price ASC
        LIMIT 1
    ) AS priceTable
    JOIN flight f ON priceTable.flight_id = f.flight_id
    JOIN airport a1 ON f.sourceAcode = a1.acode
    JOIN airport a2 ON f.destAcode = a2.acode
    JOIN flightinstance fi ON fi.flight_id = f.flight_id AND fi.date = '$date';
";

    $cheapestResult = $conn->query($sqlCheap)->fetch_assoc();
}

// --- Going flights query ---
$goingDateCondition = buildDateCondition("fi.date", $date);

$sql = "
SELECT 
    f.flight_id, f.flight_name,
    a1.city AS source_city,
    a2.city AS destination_city,
    fi.departure_time, fi.arrival_time, fi.available_seats, fi.date
FROM flight f
JOIN airport a1 ON f.sourceAcode = a1.acode
JOIN airport a2 ON f.destAcode = a2.acode
JOIN flightinstance fi ON f.flight_id = fi.flight_id
WHERE (
        a1.city = '$source'
     OR a1.state = '$source'
     OR a1.country = '$source'
     )
  AND (
        a2.city = '$destination'
     OR a2.state = '$destination'
     OR a2.country = '$destination'
     )
  $goingDateCondition
ORDER BY fi.date, fi.departure_time;
";

$result = $conn->query($sql);

echo "
<!DOCTYPE html>
<html>
<head>
<style>

@import url('https://fonts.googleapis.com/css2?family=Libertinus+Serif:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Momo+Signature&display=swap');

:root {
            --dark-blue: #0d4b75ff;
            --second-blue: #2c81baff;
            --third-blue: #35acfcff;
            --gray-colour: #1B262C;
            --white-color-light: #F4F4F4;
        }

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(to right, var(--dark-blue), var(--second-blue));
    margin: 0;
    padding: 40px;
}
.container {
      width: 95%;
      max-width: 1200px;
      background: #F4F4F4;
      margin: 40px auto;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.video-bg {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -2;
}
.overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 59, 0.6), rgba(0, 0, 0, 0.8));
            z-index: -1;
            backdrop-filter: blur(2px);
}
   
h3 {
      color: var(--second-blue);
      font-family: 'Merriweather';
      border-left: 5px solid var(--dark-blue);
      padding-left: 10px;
      margin-top: 40px;
      margin-bottom: 15px;
}
            
h2 {
font-family: 'Libertinus Serif';
font-size:35px;
color:var(--dark-blue);
margin: 37px auto;
text-align: center;
margin-bottom: 30px;
}
            
table {
    width: 93%;
    margin: 20px auto;
    border-collapse: collapse;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    background-color: white;
    border-radius: 10px;
    overflow: hidden;
}
th {
    background-color:var(--second-blue);
    color: white;
    padding: 15px;
    text-align: center;
}
td {
    padding: 18px;
    text-align: center;
    border-bottom: 1px solid #ddd;
    border: 1px solid #e5e5e5ff;
    font-family: Cambria;
}
tr:hover {
    background-color: #e9edf5ff;
    transition: 0.3s;
}
.no-data {
    text-align: center;
    color: red;
    font-size: 18px;
    margin-top: 20px;
}
.book-btn {
    background-color:var(--second-blue);
    color: var(--white-color-light);
    border: none;
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s;
}
.book-btn:hover { 
background-color: var(--dark-blue);
transform: scale(1.07);
}

/* ⭐ Added Cheapest class UI box */
.cheapest-box {
    background: #f9f4deff;
    padding: 15px;
    border-left: 6px solid #e2af2fff;
    margin-bottom: 20px;
    border-radius: 8px;
}

.cheapest-btn {
    background:var(--third-blue);
    color:white;
    border:none;
    padding:8px 18px;
    margin-right:10px;
    border-radius:6px;
    cursor:pointer;
    font-weight:bold;
}
.cheapest-btn:hover {
    background:var(--second-blue);
}

</style>
</head>
<body>

<video autoplay muted loop class='video-bg'>
    <source src='From KlickPin CF [Video] timelapse of white clouds and blue sky di 2025 _ Desainsetyawandeddy050 (online-video-cutter.com).mp4' type='video/mp4'>
</video>
<div class='overlay'></div>

<div class='container'>
<h2>Available Flights</h2>

<!-- ⭐ CHEAPEST CLASS BUTTONS -->
<form method='POST'>
    <input type='hidden' name='source' value='$source'>
    <input type='hidden' name='destination' value='$destination'>
    <input type='hidden' name='date' value='$date'>
    <input type='hidden' name='trip' value='$trip'>

    <div style='text-align:center; margin-bottom:20px;'>
        <button name='show_cheapest' value='Economy' class='cheapest-btn'>Cheapest Economy</button>
        <button name='show_cheapest' value='Business' class='cheapest-btn'>Cheapest Business</button>
        <button name='show_cheapest' value='First' class='cheapest-btn'>Cheapest First</button>
    </div>
</form>
";

# ⭐ Show cheapest result
if ($cheapestResult) {
    echo "
    <div class='cheapest-box'>
        <h3>Cheapest $selectedClass Class</h3>
        <p><b>{$cheapestResult['flight_name']}</b>  
        {$cheapestResult['source_city']} → {$cheapestResult['destination_city']}  
        | ₹{$cheapestResult['cheapest_price']}</p>

        <p>Date: {$cheapestResult['date']} | Time: {$cheapestResult['departure_time']} - {$cheapestResult['arrival_time']}</p>
    </div>
    ";
}

echo "<h3 style='text-align:left;'>Going Flights</h3>";

if ($result->num_rows > 0) {
    echo "<table>
        <tr>
            <th>Flight</th><th>Source</th><th>Destination</th>
            <th>Date</th><th>Departure</th><th>Arrival</th>
            <th>Available Seats</th><th>Book</th>
        </tr>";

    while ($row = $result->fetch_assoc()) {
        $flight_id = urlencode($row['flight_id']);
        $flight_name = htmlspecialchars($row['flight_name']);
        $from = htmlspecialchars($row['source_city']);
        $to = htmlspecialchars($row['destination_city']);
        $dateVal = htmlspecialchars($row['date']);

        echo "<tr>
            <td>$flight_name</td>
            <td>$from</td>
            <td>$to</td>
            <td>$dateVal</td>
            <td>{$row['departure_time']}</td>
            <td>{$row['arrival_time']}</td>
            <td>{$row['available_seats']}</td>
            <td><a href='booking.php?flight_id=$flight_id&source=$from&flight_name=$flight_name&destination=$to&date=$dateVal' class='book-btn'>Book Now</a></td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p class='no-data'>No flights available for this route.</p>";
}

echo "</div></body></html>";
