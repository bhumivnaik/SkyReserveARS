<?php
$conn = new mysqli("localhost", "root", "", "airport");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$airport_query = $conn->query("SELECT acode, city, aport_name FROM airport ORDER BY city ASC");
$airports = [];
while ($row = $airport_query->fetch_assoc()) {
    $airports[] = $row;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Flight Search</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Libertinus+Serif:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&family=Momo+Signature&display=swap');

        :root {
            --dark-blue: #0d4b75ff;
            --second-blue: #2c81baff;
            --third-blue: #35acfcff;
            --gray-colour: #465f6dff;
            --white-color-light: #F4F4F4;
        }

        body {
            font-family: 'Cambria';
            background: linear-gradient(to right, var(--dark-blue), var(--second-blue));
            padding: 50px;
            color: var(--white-color-light);
        }

        h2 {
            font-family: "Libertinus Serif";
            font-size: 35px;
            color: var(--dark-blue);
            margin: 37px auto;
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

        form {
            background: var(--white-color-light);
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(16, 91, 141, 0.4);
            color: var(--dark-blue);
        }

        label {
            display: block;
            margin-top: 30px;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="date"],
        input[type="submit"],
        input[type="text"] {
            width: 96%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid var(--second-blue);
            font-family: 'Cambria';
            font-size: 13px;
            color: var(--gray-colour);
        }

        /* Submit Button */
        input[type="submit"] {
            background: linear-gradient(135deg, var(--second-blue), var(--dark-blue));
            color: var(--white-color-light);
            cursor: pointer;
            padding: 10px 15px;
            margin-top: 15px;
            width: 100%;
            border: none;
            font-size: medium;
            box-shadow: 0 0 15px rgba(53, 172, 252, 0.5);
        }

        input[type="submit"]:hover {
            transform: scale(1.07);
            box-shadow: 0 0 25px rgba(53, 172, 252, 0.3);
            background: linear-gradient(135deg, var(--dark-blue), var(--second-blue));
        }

        /* Custom dropdown styling */
        .custom-select {
            position: relative;
            width: 100%;
        }

        .city {
            font-weight: bold;
        }

        .airport {
            font-size: 12px;
            color: #a4a4a4ff;
        }

        .date-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 35px;
            margin-bottom: 25px;
        }


        .select-items {
            position: absolute;
            background: var(--white-color-light);
            border: 1px solid var(--second-blue);
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            display: none;
            z-index: 50;
            border-radius: 5px;
        }

        .option {
            padding: 8px;
            cursor: pointer;
        }

        .option:hover,
        .option.highlight {
            background: var(--second-blue);
            color: white;
        }




        .select-selected {
            background-color: var(--white-color-light);
            padding: 10px;
            border: 1px solid var(--second-blue);
            border-radius: 5px;
            min-height: 8px;
            cursor: text;
            color: var(--gray-colour);
            outline: none;
            font-size: 14px;
        }

        .select-items div {
            padding: 8px;
            cursor: pointer;
            color: var(--dark-blue);
        }

        .select-items div:hover {
            background-color: var(--second-blue);
            color: white;
        }
    </style>

</head>

<body>
    <video autoplay muted loop class="video-bg">
        <source src="From KlickPin CF [Video] timelapse of white clouds and blue sky di 2025 _ Desainsetyawandeddy050 (online-video-cutter.com).mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <div class="overlay"></div>



    <form action="flight_search.php" method="POST">
        <h2 style="text-align:center; ">Find your Flights</h2>

        <label>Source:</label>
        <div class="custom-select" id="sourceSelect">
            <div class="select-selected" contenteditable="true" style="text-transform: capitalize;">Select Source</div>
            <div class="select-items">
                <?php foreach ($airports as $airport): ?>
                    <div data-value="<?= $airport['city'] ?>"
                        data-city="<?= strtolower($airport['city']) ?>"
                        data-airport="<?= strtolower($airport['aport_name']) ?>">
                        <span class="city"><?= $airport['city'] ?></span><br>
                        <span class="airport"><?= $airport['aport_name'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <input type="hidden" name="source">
        </div>

        <label>Destination:</label>
        <div class="custom-select" id="destinationSelect">
            <div class="select-selected" contenteditable="true" style="text-transform: capitalize;">Select Destination</div>
            <div class="select-items">
                <?php foreach ($airports as $airport): ?>
                    <div data-value="<?= $airport['city'] ?>"
                        data-city="<?= strtolower($airport['city']) ?>"
                        data-airport="<?= strtolower($airport['aport_name']) ?>">
                        <span class="city"><?= $airport['city'] ?></span><br>
                        <span class="airport"><?= $airport['aport_name'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <input type="hidden" name="destination">
        </div>



        <!-- Dates -->
        <div class="date-grid">
            <div>
                <label>Outbound Date</label>
                <input type="date" name="date">

            </div>

        </div>


        <input type="submit" value="Search Flights">
    </form>

    <script>
        function setupCustomSelect(selectId) {
            const select = document.getElementById(selectId);
            const selected = select.querySelector('.select-selected');
            const items = select.querySelector('.select-items');
            const input = select.querySelector('input');

            // Open dropdown when clicking
            selected.addEventListener('click', () => {
                items.style.display = "block";
                selected.textContent = ""; // Clear typed placeholder
            });

            // Live search on typing
            selected.addEventListener('input', () => {
                const filter = selected.textContent.toLowerCase();

                items.querySelectorAll('div').forEach(option => {
                    const city = option.dataset.city;
                    const airport = option.dataset.airport;

                    if (city.includes(filter) || airport.includes(filter)) {
                        option.style.display = "block";
                    } else {
                        option.style.display = "none";
                    }
                });
            });

            // On selecting an item
            items.querySelectorAll('div').forEach(option => {
                option.addEventListener('click', () => {
                    const city = option.dataset.value;
                    const airport = option.querySelector('.airport').innerText;

                    selected.innerHTML = `
                <span class="city">${city}</span><br>
                <span class="airport">${airport}</span>
            `;
                    input.value = city;

                    items.style.display = "none";
                });
            });

            // Close if clicking outside
            document.addEventListener('click', e => {
                if (!select.contains(e.target)) items.style.display = "none";
            });
        }

        setupCustomSelect('sourceSelect');
        setupCustomSelect('destinationSelect');
    </script>

</body>

</html>
