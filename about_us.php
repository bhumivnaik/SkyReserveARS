<?php
$conn = new mysqli("localhost", "root", "", "airport");

$stats = [
    "total_flights" => "SELECT COUNT(*) AS value FROM flight",
    "total_routes"  => "SELECT COUNT(DISTINCT CONCAT(sourceAcode,'-',destAcode)) AS value FROM flight",
    "total_airports" => "SELECT COUNT(*) AS value FROM airport",
    "total_bookings" => "SELECT COUNT(*) AS value FROM booking",
    "total_passengers" => "SELECT COUNT(*) AS value FROM passenger"
];

$data = [];
foreach ($stats as $key => $sql) {
    $result = $conn->query($sql)->fetch_assoc();
    $data[$key] = $result['value'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>About SkyReserve</title>

    <style>
        /* ------------------ COLORS ------------------ */
        :root {
            --dark-blue: #0d4b75;
            --mid-blue: #2c81ba;
            --light-blue: #35acfc;
            --glass-light: rgba(255, 255, 255, 0.25);
            --glass-dark: rgba(255, 255, 255, 0.05);
            --text-light: #eaf7ff;
        }

        /* ------------------ BASE ------------------ */
        body {
            margin: 0;
            color: white;
            font-family: "Segoe UI", Cambria;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* BG VIDEO */
        .video-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
        }

        /* Overlay */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 40, 0.6), rgba(0, 0, 0, 0.8));
            z-index: -1;
        }

        /* ------------------ HERO ------------------ */
        .hero-box {
            text-align: center;
            margin-top: 70px;
            animation: fadeIn 1.5s ease;
        }

        .hero-title {
            font-size: 65px;
            font-family: "Libertinus Serif";
            font-weight: 700;
            text-shadow: 0 0 18px rgba(53, 172, 252, 0.6);
            color: #73c7ffff
        }

        .hero-subtitle {
            font-style: italic;
            font-family: Cambria;
            font-size: 19px;
            color: var(--text-light);
        }

        /* ------------------ ABOUT TEXT ------------------ */
        .about-text {
            max-width: 850px;
            margin: 20px auto 50px;
            text-align: center;
            color: #e8f6ff;
            font-size: 18px;
            line-height: 1.7;
            padding: 0 20px;
            animation: fadeInUp 1.5s ease;
        }

        /* ------------------ STATS ------------------ */
        .stats-title {
            text-align: center;
            margin-bottom: 25px;
            font-size: 33px;
            font-family: "Libertinus Serif";
        }

        .stats-row {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
            padding-bottom: 0px;
        }

        /* CARD GLASS EFFECT */
        .stat-card {
            width: 200px;
            padding: 35px 20px;
            text-align: center;
            border-radius: 22px;

            background: var(--glass-dark);
            border: 1px solid var(--glass-light);
            backdrop-filter: blur(14px);

            box-shadow:
                0 8px 25px rgba(0, 0, 0, 0.35),
                inset 0 0 14px rgba(255, 255, 255, 0.08);

            transition: 0.35s ease;
            animation: fadeInUp 1s ease;
        }

        /* Hover lift */
        .stat-card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow:
                0 12px 28px rgba(0, 0, 0, 0.45),
                inset 0 0 18px rgba(255, 255, 255, 0.15);
        }

        /* Numbers */
        .number {
            font-size: 75px;
            font-weight: 700;
            letter-spacing: -2px;
            font-family: 'Times New Roman';
            background: linear-gradient(90deg, var(--light-blue), #fff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Label */
        .label {
            font-size: 16px;
            margin-top: 8px;
            letter-spacing: 1px;
            color: #dce9f2;
        }

        /* ------------------ ANIMATIONS ------------------ */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <!-- Background -->
    <video autoplay muted loop class="video-bg">
        <source src="From KlickPin CF [Video] timelapse of white clouds and blue sky di 2025 _ Desainsetyawandeddy050 (online-video-cutter.com).mp4" type="video/mp4">
    </video>
    <div class="overlay"></div>

    <!-- HERO -->
    <div class="hero-box">
        <h1 class="hero-title">About SkyReserve</h1>
        <p class="hero-subtitle">Your smooth, simple & smart flight booking partner</p>
    </div>

    <!-- ABOUT DESCRIPTION -->
    <p class="about-text">
        SkyReserve makes flight booking effortless with real-time updates, smart suggestions,
        and a premium modern interface. Designed for ease, speed, and performance — your travel
        planning becomes smoother than ever.
    </p>

    <!-- STATS SECTION -->
    <h2 class="stats-title">Our Journey In Numbers</h2>

    <div class="stats-row">

        <div class="stat-card">
            <div class="number counter" data-target="<?= $data['total_flights'] ?>">0</div>
            <div class="label">Flights</div>
        </div>

        <div class="stat-card">
            <div class="number counter" data-target="<?= $data['total_routes'] ?>">0</div>
            <div class="label">Routes</div>
        </div>

        <div class="stat-card">
            <div class="number counter" data-target="<?= $data['total_airports'] ?>">0</div>
            <div class="label">Airports</div>
        </div>

        <div class="stat-card">
            <div class="number counter" data-target="<?= $data['total_bookings'] ?>">0</div>
            <div class="label">Bookings</div>
        </div>

        <div class="stat-card">
            <div class="number counter" data-target="<?= $data['total_passengers'] ?>">0</div>
            <div class="label">Passengers</div>
        </div>

    </div>

    <!-- COUNTER ANIMATION -->
    <script>
        const counters = document.querySelectorAll(".counter");

        counters.forEach(counter => {
            counter.innerText = "0";

            const update = () => {
                const target = +counter.getAttribute("data-target");
                const current = +counter.innerText;

                const speed = 2000;
                const inc = Math.ceil(target / speed);

                if (current < target) {
                    counter.innerText = current + inc;
                    requestAnimationFrame(update);
                } else {
                    counter.innerText = target;
                }
            };

            update();
        });
    </script>

</body>

</html>
