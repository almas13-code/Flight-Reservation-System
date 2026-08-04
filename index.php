<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyReserve | Book Your Flight</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="landing-body">

<!-- Navigation Bar -->
<nav class="navbar">
    <a href="index.php" class="nav-brand">
        <div class="brand-icon"><i class="fa-solid fa-plane-departure"></i></div>
        SkyReserve
    </a>

    <div class="nav-right">
        <a href="login.php" class="btn btn-ghost"><i class="fa-solid fa-right-to-bracket"></i> Sign In</a>
        <a href="register.php" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i> Get Started</a>
    </div>
</nav>

<!-- Hero Section & Search Bar -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-eyebrow">
            <span class="dot"></span>
            Smart Flight Reservation System
        </div>

        <h1 class="hero-title">
            <span class="text-gradient">Your Journey Starts Here</span>
        </h1>

        <p class="hero-subtitle">
            Find the best flights, compare prices, and book your next trip with confidence.
        </p>

        <div class="hero-cta">
            <a href="flights.php" class="btn btn-primary btn-lg">
                <i class="fa-solid fa-magnifying-glass"></i> Explore Flights
            </a>
            <a href="register.php" class="btn btn-outline btn-lg">
                <i class="fa-solid fa-user-plus"></i> Get Started
            </a>
        </div>
    </div>

    <!-- Flight Search Widget -->
    <div class="search-widget">
        <form action="flights.php" method="GET">
            <div class="search-row">
                <div class="search-field">
                    <span class="search-label"><i class="fa-solid fa-plane-departure"></i>&nbsp; Departure City</span>
                    <div class="search-input-wrap">
                        <i class="fa-solid fa-location-dot"></i>
                        <input type="text" name="source" class="search-input" placeholder="e.g. Delhi, Mumbai">
                    </div>
                </div>

                <button type="button" class="swap-btn" title="Swap Cities">
                    <i class="fa-solid fa-arrows-left-right"></i>
                </button>

                <div class="search-field">
                    <span class="search-label"><i class="fa-solid fa-plane-arrival"></i>&nbsp; Arrival City</span>
                    <div class="search-input-wrap">
                        <i class="fa-solid fa-location-dot"></i>
                        <input type="text" name="destination" class="search-input" placeholder="e.g. Bangalore, Goa">
                    </div>
                </div>

                <button type="submit" class="search-btn">
                    <i class="fa-solid fa-magnifying-glass"></i> Search Flights
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <div class="footer-icon"><i class="fa-solid fa-plane-departure"></i></div>
            SkyReserve
        </div>
        <div class="footer-copy">
            &copy; <?php echo date('Y'); ?> SkyReserve. All rights reserved.
        </div>
    </div>
</footer>

<script>
// Swap departure and arrival input values
document.querySelector('.swap-btn')?.addEventListener('click', function() {
    const src = document.querySelector('input[name="source"]');
    const dst = document.querySelector('input[name="destination"]');
    const tmp = src.value;
    src.value = dst.value;
    dst.value = tmp;
});
</script>

</body>
</html>