<?php
session_start();
include("config.php");

// Fetch departure and arrival filter inputs
$source_filter = isset($_GET['source']) ? trim($_GET['source']) : '';
$dest_filter   = isset($_GET['destination']) ? trim($_GET['destination']) : '';

// Build database search query
$sql = "SELECT * FROM flights WHERE 1=1";
if (!empty($source_filter)) {
    $safe = $conn->real_escape_string($source_filter);
    $sql .= " AND source_city LIKE '%$safe%'";
}
if (!empty($dest_filter)) {
    $safe = $conn->real_escape_string($dest_filter);
    $sql .= " AND destination_city LIKE '%$safe%'";
}
$sql .= " ORDER BY departure_time ASC";
$result = $conn->query($sql);
$total  = $result ? $result->num_rows : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Flights | SkyReserve</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar">
    <a href="index.php" class="nav-brand">
        <div class="brand-icon"><i class="fa-solid fa-plane-departure"></i></div>
        SkyReserve
    </a>
    <div class="nav-right">
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="my_bookings.php" class="btn btn-ghost"><i class="fa-solid fa-ticket"></i> My Bookings</a>
            <span style="color:rgba(255,255,255,0.8); font-size:0.9rem;"><i class="fa-solid fa-circle-user"></i> <?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
            <a href="logout.php" class="btn btn-ghost"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-ghost"><i class="fa-solid fa-right-to-bracket"></i> Sign In</a>
            <a href="register.php" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i> Register</a>
        <?php endif; ?>
    </div>
</nav>

<!-- Page Header Banner -->
<div class="page-hero">
    <div class="page-hero-inner" style="display:flex; align-items:center; justify-content:center; gap:1rem; flex-wrap:wrap;">
        <h1 class="page-title" style="margin:0; font-size:1.6rem; color:#ffffff;">Available Flights</h1>

        <span style="font-size:0.8rem; font-weight:700; color:#34d399; background:rgba(16,185,129,0.12); border:1px solid rgba(16,185,129,0.25); padding:0.35rem 0.85rem; border-radius:20px; display:inline-flex; align-items:center; gap:0.4rem;">
            <i class="fa-solid fa-circle-check"></i> <?php echo $total; ?> flight<?php echo $total !== 1 ? 's' : ''; ?> found
        </span>
    </div>
</div>

<!-- Flight Search Filter Form -->
<form method="GET" action="flights.php">
    <div class="filter-bar">
        <div class="filter-field">
            <span class="filter-label"><i class="fa-solid fa-plane-departure"></i>&nbsp; From</span>
            <div class="filter-input-wrap">
                <i class="fa-solid fa-location-dot"></i>
                <input type="text" name="source" class="filter-input" placeholder="Source city..." value="<?php echo htmlspecialchars($source_filter); ?>">
            </div>
        </div>

        <div class="filter-field">
            <span class="filter-label"><i class="fa-solid fa-plane-arrival"></i>&nbsp; To</span>
            <div class="filter-input-wrap">
                <i class="fa-solid fa-location-dot"></i>
                <input type="text" name="destination" class="filter-input" placeholder="Destination city..." value="<?php echo htmlspecialchars($dest_filter); ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="align-self:flex-end;">
            <i class="fa-solid fa-filter"></i> Filter
        </button>

        <?php if ($source_filter || $dest_filter): ?>
        <a href="flights.php" class="btn btn-ghost" style="align-self:flex-end;">
            <i class="fa-solid fa-xmark"></i> Clear
        </a>
        <?php endif; ?>
    </div>
</form>

<!-- Available Flights List -->
<div class="flights-container">
<?php
if ($result && $result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
        $seats      = (int)$row['available_seats'];
        $badgeClass = $seats > 20 ? 'badge-success' : ($seats > 5 ? 'badge-warning' : 'badge-info');
        $badgeIcon  = $seats > 20 ? 'fa-circle-check' : ($seats > 5 ? 'fa-triangle-exclamation' : 'fa-fire');
        $dep_time   = date('h:i A', strtotime($row['departure_time']));
        $arr_time   = date('h:i A', strtotime($row['arrival_time']));
        $dep_date   = date('d M', strtotime($row['departure_time']));
        $src_code   = strtoupper(substr($row['source_city'], 0, 3));
        $dst_code   = strtoupper(substr($row['destination_city'], 0, 3));
?>
    <div class="flight-card">
        <!-- Airline Details -->
        <div class="flight-airline-info">
            <div class="airline-logo"><i class="fa-solid fa-plane"></i></div>
            <div>
                <div class="airline-name"><?php echo htmlspecialchars($row['airline_name']); ?></div>
                <div class="flight-number">Flight &nbsp;<?php echo htmlspecialchars($row['flight_number']); ?></div>
            </div>
        </div>

        <!-- Flight Route -->
        <div class="flight-route">
            <div class="route-city">
                <div class="route-city-time"><?php echo $dep_time; ?></div>
                <div class="route-city-code"><?php echo $src_code; ?></div>
                <div class="route-city-name"><?php echo htmlspecialchars($row['source_city']); ?></div>
            </div>

            <div class="route-arrow">
                <div class="route-line-container">
                    <div class="route-dot"></div>
                    <div class="route-line"></div>
                    <i class="fa-solid fa-plane route-plane-icon"></i>
                    <div class="route-line"></div>
                    <div class="route-dot" style="border-color: var(--cyan-400);"></div>
                </div>
                <div style="font-size:0.72rem; color:rgba(255,255,255,0.25); margin-top:4px;"><?php echo $dep_date; ?></div>
            </div>

            <div class="route-city">
                <div class="route-city-time" style="color: var(--cyan-400);"><?php echo $arr_time; ?></div>
                <div class="route-city-code"><?php echo $dst_code; ?></div>
                <div class="route-city-name"><?php echo htmlspecialchars($row['destination_city']); ?></div>
            </div>
        </div>

        <!-- Seat Status -->
        <div>
            <span class="badge <?php echo $badgeClass; ?>">
                <i class="fa-solid <?php echo $badgeIcon; ?>"></i>
                <?php echo $seats; ?> left
            </span>
            <div class="seats-label">Available seats</div>
        </div>

        <!-- Ticket Price & Booking Action -->
        <div class="flight-price-col">
            <div>
                <div class="price-amount">AED <?php echo number_format($row['ticket_price']); ?></div>
                <div class="price-per">per person</div>
            </div>
            <a href="<?php echo isset($_SESSION['user_id']) ? 'book.php?flight_id='.$row['flight_id'] : 'login.php'; ?>" class="btn btn-primary" style="padding:0.55rem 1.25rem; font-size:0.85rem; border-radius:8px;">
                Book Now <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
<?php
    endwhile;
else:
?>
    <div class="empty-state">
        <i class="fa-solid fa-plane-slash"></i>
        <h3>No Flights Found</h3>
        <p>Try changing your search filters.</p>
        <br>
        <a href="flights.php" class="btn btn-outline"><i class="fa-solid fa-arrows-rotate"></i> Reset Search</a>
    </div>
<?php endif; ?>
</div>

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

</body>
</html>