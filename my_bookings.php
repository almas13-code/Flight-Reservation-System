<?php
session_start();
include("config.php");

// Redirect to sign in page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = (int)$_SESSION['user_id'];
$success = isset($_GET['success']) && $_GET['success'] == 1;

// Fetch user's booking history joined with flight and payment details
$sql = "SELECT b.booking_id, b.booking_date, b.seats_booked, b.booking_status,
               f.flight_number, f.airline_name, f.source_city, f.destination_city,
               f.departure_time, f.arrival_time, f.ticket_price,
               p.payment_method, p.amount, p.payment_status
        FROM bookings b
        JOIN flights f ON b.flight_id = f.flight_id
        LEFT JOIN payments p ON b.booking_id = p.booking_id
        WHERE b.user_id = $user_id
        ORDER BY b.booking_date DESC";
$result  = $conn->query($sql);
$bookings = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings | SkyReserve</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .bookings-page { min-height: 100vh; padding: 6rem 6% 4rem; background: var(--navy-950); }
        .bookings-grid { max-width: 1100px; margin: 0 auto; display: flex; flex-direction: column; gap: 1rem; }
        .booking-card { background: rgba(10,22,40,0.9); border: 1px solid rgba(255,255,255,0.07); border-radius: var(--radius-lg); padding: 1.75rem 2rem; display: grid; grid-template-columns: 2fr 2fr 1fr 1fr; gap: 1.5rem; align-items: center; position: relative; overflow: hidden; transition: all 0.3s ease; }
        .booking-card::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px; background: var(--accent-gradient); }
        .booking-card:hover { border-color: rgba(59,130,246,0.2); box-shadow: 0 8px 30px rgba(0,0,0,0.3); }
        .booking-id { font-size: 0.72rem; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.35rem; }
        .booking-airline { font-family: var(--font-display); font-size: 1.05rem; font-weight: 700; }
        .booking-flight-num { font-size: 0.78rem; color: rgba(255,255,255,0.5); margin-top: 0.1rem; }
        .booking-route { display: flex; align-items: center; gap: 0.75rem; }
        .booking-city-code { font-family: var(--font-display); font-size: 1.4rem; font-weight: 800; }
        .booking-arrow { color: var(--cyan-400); font-size: 0.9rem; }
        .booking-date { font-size: 0.8rem; color: rgba(255,255,255,0.5); margin-top: 0.3rem; }
        .booking-meta { font-size: 0.82rem; color: rgba(255,255,255,0.6); margin-bottom: 0.3rem; }
        .booking-amount { font-family: var(--font-display); font-size: 1.3rem; font-weight: 800; color: var(--cyan-400); }
        .booking-pay-method { font-size: 0.75rem; color: rgba(255,255,255,0.5); margin-top: 0.2rem; }
        .success-banner { max-width: 1100px; margin: 0 auto 1.5rem; background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.25); border-radius: var(--radius-md); padding: 1rem 1.5rem; display: flex; align-items: center; gap: 0.75rem; color: #34d399; font-weight: 600; }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar">
    <a href="index.php" class="nav-brand">
        <div class="brand-icon"><i class="fa-solid fa-plane-departure"></i></div>
        SkyReserve
    </a>
    <div class="nav-right">
        <a href="flights.php" class="btn btn-ghost"><i class="fa-solid fa-plane"></i> Flights</a>
        <span style="color:rgba(255,255,255,0.7); font-size:0.9rem;"><i class="fa-solid fa-circle-user"></i> <?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
        <a href="logout.php" class="btn btn-ghost"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</nav>

<div class="bookings-page">
    <!-- Page Header Banner -->
    <div style="max-width:1100px; margin:0 auto 2rem; text-align:center;">
        <p style="font-size:0.8rem; text-transform:uppercase; letter-spacing:1.2px; color:var(--blue-400); font-weight:700; margin-bottom:0.4rem;">
            <i class="fa-solid fa-ticket"></i>&nbsp; History
        </p>
        <h1 style="font-family:var(--font-display); font-size:2.25rem; font-weight:800; letter-spacing:-1px; margin-bottom:0.3rem;">My Bookings</h1>
        <p style="color:rgba(255,255,255,0.6); font-size:0.9rem;">Welcome back, <?php echo htmlspecialchars($_SESSION['full_name']); ?>! You have <?php echo count($bookings); ?> booking<?php echo count($bookings) !== 1 ? 's' : ''; ?>.</p>
    </div>

    <?php if ($success): ?>
    <div class="success-banner">
        <i class="fa-solid fa-circle-check fa-lg"></i>
        Booking confirmed successfully! Your seat is reserved and payment recorded.
    </div>
    <?php endif; ?>

    <!-- User Booking Cards List -->
    <div class="bookings-grid">
        <?php if (empty($bookings)): ?>
        <div class="empty-state" style="padding:4rem 2rem; text-align:center;">
            <i class="fa-solid fa-ticket" style="font-size:3.5rem; color:rgba(255,255,255,0.1); display:block; margin-bottom:1.5rem;"></i>
            <h3 style="font-family:var(--font-display); font-size:1.5rem; margin-bottom:0.75rem;">No Bookings Yet</h3>
            <p style="color:rgba(255,255,255,0.5); margin-bottom:1.5rem;">You haven't booked any flights yet.</p>
            <a href="flights.php" class="btn btn-primary"><i class="fa-solid fa-plane"></i> Browse Flights</a>
        </div>
        <?php else: ?>
            <?php foreach($bookings as $b):
                $src_code = strtoupper(substr($b['source_city'], 0, 3));
                $dst_code = strtoupper(substr($b['destination_city'], 0, 3));
                $dep_date = date('d M Y, h:i A', strtotime($b['departure_time']));
                $book_date = date('d M Y', strtotime($b['booking_date']));
            ?>
            <div class="booking-card">
                <!-- Airline Details -->
                <div>
                    <div class="booking-id">Booking #<?php echo str_pad($b['booking_id'], 4, '0', STR_PAD_LEFT); ?></div>
                    <div class="booking-airline"><?php echo htmlspecialchars($b['airline_name']); ?></div>
                    <div class="booking-flight-num">Flight <?php echo htmlspecialchars($b['flight_number']); ?></div>
                    <div class="booking-date" style="margin-top:0.5rem;"><i class="fa-solid fa-calendar fa-xs"></i>&nbsp; Booked on <?php echo $book_date; ?></div>
                </div>

                <!-- Flight Route Details -->
                <div>
                    <div class="booking-route">
                        <div>
                            <div class="booking-city-code"><?php echo $src_code; ?></div>
                            <div style="font-size:0.72rem; color:rgba(255,255,255,0.5);"><?php echo htmlspecialchars($b['source_city']); ?></div>
                        </div>
                        <i class="fa-solid fa-plane booking-arrow"></i>
                        <div>
                            <div class="booking-city-code"><?php echo $dst_code; ?></div>
                            <div style="font-size:0.72rem; color:rgba(255,255,255,0.5);"><?php echo htmlspecialchars($b['destination_city']); ?></div>
                        </div>
                    </div>
                    <div class="booking-date"><i class="fa-solid fa-clock fa-xs"></i>&nbsp; <?php echo $dep_date; ?></div>
                </div>

                <!-- Seats & Payment Method -->
                <div>
                    <div class="booking-meta"><i class="fa-solid fa-chair fa-xs"></i>&nbsp; <?php echo $b['seats_booked']; ?> seat<?php echo $b['seats_booked'] > 1 ? 's' : ''; ?></div>
                    <div class="booking-meta"><i class="fa-solid fa-credit-card fa-xs"></i>&nbsp; <?php echo htmlspecialchars($b['payment_method'] ?? 'N/A'); ?></div>
                    <span class="badge badge-success" style="margin-top:0.4rem;">
                        <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($b['booking_status']); ?>
                    </span>
                </div>

                <!-- Total Payment Amount -->
                <div style="text-align:right;">
                    <div style="font-size:0.72rem; color:rgba(255,255,255,0.4); margin-bottom:0.25rem;">Total Paid</div>
                    <div class="booking-amount">AED <?php echo number_format($b['amount'] ?? ($b['seats_booked'] * $b['ticket_price'])); ?></div>
                    <div class="booking-pay-method"><?php echo htmlspecialchars($b['payment_status'] ?? 'Paid'); ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
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
