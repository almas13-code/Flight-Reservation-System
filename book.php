<?php
session_start();
include("config.php");

// Redirect to sign in page if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Validate requested flight ID
$flight_id = isset($_GET['flight_id']) ? (int)$_GET['flight_id'] : 0;
if ($flight_id === 0) { 
    header("Location: flights.php"); 
    exit(); 
}

// Fetch details for the selected flight
$sql    = "SELECT * FROM flights WHERE flight_id = $flight_id";
$result = $conn->query($sql);
if (!$result || $result->num_rows === 0) { 
    header("Location: flights.php"); 
    exit(); 
}
$flight = $result->fetch_assoc();

$message = "";
$message_type = "";

// Handle flight booking form submission
if (isset($_POST['book'])) {
    $seats_booked   = (int)$_POST['seats_booked'];
    $payment_method = $conn->real_escape_string($_POST['payment_method']);
    $user_id        = (int)$_SESSION['user_id'];
    $total_amount   = $seats_booked * $flight['ticket_price'];

    if ($seats_booked < 1 || $seats_booked > $flight['available_seats']) {
        $message      = "Invalid number of seats. Only " . $flight['available_seats'] . " available.";
        $message_type = "danger";
    } else {
        // Record new booking in database
        $sql_book = "INSERT INTO bookings(user_id, flight_id, seats_booked, booking_status)
                     VALUES($user_id, $flight_id, $seats_booked, 'Confirmed')";
        if ($conn->query($sql_book)) {
            $booking_id = $conn->insert_id;
            
            // Record payment details in database
            $sql_pay = "INSERT INTO payments(booking_id, payment_method, amount, payment_status)
                        VALUES($booking_id, '$payment_method', $total_amount, 'Paid')";
            $conn->query($sql_pay);
            
            header("Location: my_bookings.php?success=1");
            exit();
        } else {
            $message      = "Booking failed. Please try again.";
            $message_type = "danger";
        }
    }
}

// Format flight dates and city airport codes for display
$dep_date = date('D, d M Y', strtotime($flight['departure_time']));
$dep_time = date('h:i A', strtotime($flight['departure_time']));
$arr_time = date('h:i A', strtotime($flight['arrival_time']));
$src_code = strtoupper(substr($flight['source_city'], 0, 3));
$dst_code = strtoupper(substr($flight['destination_city'], 0, 3));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Flight | SkyReserve</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .book-page { min-height: 100vh; padding: 6rem 6% 4rem; background: var(--navy-950); }
        .book-container { max-width: 900px; margin: 0 auto; display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 2rem; align-items: start; }
        .book-card { background: rgba(10,22,40,0.9); border: 1px solid rgba(255,255,255,0.08); border-radius: var(--radius-lg); padding: 2rem; }
        .book-flight-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.75rem; padding-bottom: 1.75rem; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .book-airline-logo { width: 52px; height: 52px; border-radius: var(--radius-sm); background: linear-gradient(135deg, rgba(59,130,246,0.15),rgba(6,182,212,0.1)); border: 1px solid rgba(59,130,246,0.2); display:flex; align-items:center; justify-content:center; color: var(--blue-400); font-size: 1.3rem; }
        .book-route { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
        .book-city { text-align: center; }
        .book-city-code { font-family: var(--font-display); font-size: 2rem; font-weight: 800; line-height: 1; }
        .book-city-name { font-size: 0.78rem; color: rgba(255,255,255,0.6); margin-top: 0.25rem; }
        .book-city-time { font-size: 0.85rem; color: var(--blue-400); font-weight: 600; margin-bottom: 0.2rem; }
        .book-arrow { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 4px; }
        .book-line-wrap { width: 100%; display: flex; align-items: center; gap: 4px; }
        .book-dot { width: 8px; height: 8px; border-radius: 50%; border: 2px solid var(--blue-400); flex-shrink:0; }
        .book-line { flex: 1; height: 1px; background: linear-gradient(90deg, var(--blue-400), var(--cyan-400)); opacity: 0.5; }
        .book-plane { color: var(--cyan-400); font-size: 1rem; }
        .book-info-row { display: flex; justify-content: space-between; align-items: center; padding: 0.65rem 0; border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 0.88rem; }
        .book-info-row:last-child { border-bottom: none; }
        .book-info-label { color: rgba(255,255,255,0.5); }
        .book-info-value { font-weight: 600; }
        .book-form-title { font-family: var(--font-display); font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem; }
        .book-form-group { display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1.1rem; }
        .book-form-label { font-size: 0.82rem; font-weight: 600; color: rgba(255,255,255,0.7); }
        .book-form-input, .book-form-select { width: 100%; padding: 0.85rem 1rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: var(--radius-sm); color: var(--text-white); font-family: var(--font-body); font-size: 0.9rem; outline: none; transition: all 0.25s ease; }
        .book-form-select option { background: #0a1628; }
        .book-form-input:focus, .book-form-select:focus { border-color: rgba(59,130,246,0.5); background: rgba(59,130,246,0.06); box-shadow: 0 0 0 3px rgba(59,130,246,0.12); }
        .book-total { background: rgba(59,130,246,0.08); border: 1px solid rgba(59,130,246,0.2); border-radius: var(--radius-sm); padding: 1rem; margin-bottom: 1.25rem; display: flex; justify-content: space-between; align-items: center; }
        .book-total-label { font-size: 0.85rem; color: rgba(255,255,255,0.7); }
        .book-total-amount { font-family: var(--font-display); font-size: 1.5rem; font-weight: 800; color: var(--cyan-400); }
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
        <a href="my_bookings.php" class="btn btn-ghost"><i class="fa-solid fa-ticket"></i> My Bookings</a>
        <span style="color:rgba(255,255,255,0.7); font-size:0.9rem;"><i class="fa-solid fa-circle-user"></i> <?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
        <a href="logout.php" class="btn btn-ghost"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</nav>

<div class="book-page">
    <div style="max-width:900px; margin:0 auto 1.5rem;">
        <a href="flights.php" style="color:var(--blue-400); text-decoration:none; font-size:0.9rem; font-weight:500;">
            <i class="fa-solid fa-arrow-left"></i> Back to Flights
        </a>
    </div>

    <?php if (!empty($message)): ?>
    <div class="book-container" style="display:block; max-width:900px; margin: 0 auto 1.5rem;">
        <div class="auth-alert auth-alert-<?php echo $message_type; ?>">
            <i class="fa-solid fa-circle-exclamation"></i> <?php echo htmlspecialchars($message); ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="book-container">
        <!-- Selected Flight Summary Card -->
        <div class="book-card">
            <div class="book-flight-header">
                <div class="book-airline-logo"><i class="fa-solid fa-plane"></i></div>
                <div>
                    <div style="font-family:var(--font-display); font-size:1.1rem; font-weight:700;"><?php echo htmlspecialchars($flight['airline_name']); ?></div>
                    <div style="font-size:0.78rem; color:rgba(255,255,255,0.5);">Flight <?php echo htmlspecialchars($flight['flight_number']); ?> &nbsp;·&nbsp; <?php echo $dep_date; ?></div>
                </div>
            </div>

            <!-- Route Details -->
            <div class="book-route">
                <div class="book-city">
                    <div class="book-city-time"><?php echo $dep_time; ?></div>
                    <div class="book-city-code"><?php echo $src_code; ?></div>
                    <div class="book-city-name"><?php echo htmlspecialchars($flight['source_city']); ?></div>
                </div>
                <div class="book-arrow">
                    <div class="book-line-wrap">
                        <div class="book-dot"></div>
                        <div class="book-line"></div>
                        <i class="fa-solid fa-plane book-plane"></i>
                        <div class="book-line"></div>
                        <div class="book-dot" style="border-color:var(--cyan-400);"></div>
                    </div>
                </div>
                <div class="book-city">
                    <div class="book-city-time" style="color:var(--cyan-400);"><?php echo $arr_time; ?></div>
                    <div class="book-city-code"><?php echo $dst_code; ?></div>
                    <div class="book-city-name"><?php echo htmlspecialchars($flight['destination_city']); ?></div>
                </div>
            </div>

            <!-- Flight Information Row -->
            <div class="book-info-row">
                <span class="book-info-label"><i class="fa-solid fa-chair fa-sm"></i>&nbsp; Available Seats</span>
                <span class="book-info-value"><?php echo $flight['available_seats']; ?></span>
            </div>
            <div class="book-info-row">
                <span class="book-info-label"><i class="fa-solid fa-tag fa-sm"></i>&nbsp; Price per Seat</span>
                <span class="book-info-value" style="color:var(--cyan-400);">AED <?php echo number_format($flight['ticket_price']); ?></span>
            </div>
            <div class="book-info-row">
                <span class="book-info-label"><i class="fa-solid fa-circle-check fa-sm" style="color:#34d399;"></i>&nbsp; Status</span>
                <span class="book-info-value" style="color:#34d399;">Available</span>
            </div>
        </div>

        <!-- Seat Selection & Payment Form -->
        <div class="book-card">
            <div class="book-form-title"><i class="fa-solid fa-ticket" style="color:var(--blue-400);"></i>&nbsp; Complete Your Booking</div>

            <form method="POST" id="bookForm">
                <div class="book-form-group">
                    <label class="book-form-label">Number of Seats</label>
                    <input type="number" name="seats_booked" class="book-form-input" id="seatsInput"
                           min="1" max="<?php echo $flight['available_seats']; ?>"
                           placeholder="Enter number of seats" required
                           onchange="updateTotal(this.value)">
                </div>

                <div class="book-form-group">
                    <label class="book-form-label">Payment Method</label>
                    <select name="payment_method" class="book-form-select" required>
                        <option value="">-- Select Payment Method --</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Debit Card">Debit Card</option>
                        <option value="UPI">UPI</option>
                        <option value="Net Banking">Net Banking</option>
                    </select>
                </div>

                <div class="book-total">
                    <span class="book-total-label">Total Amount</span>
                    <span class="book-total-amount" id="totalAmount">AED 0</span>
                </div>

                <button type="submit" name="book" class="btn btn-primary" style="width:100%; justify-content:center; padding:0.95rem; border-radius:var(--radius-sm); font-size:1rem;">
                    <i class="fa-solid fa-check-circle"></i> Confirm Booking
                </button>
            </form>

            <div style="margin-top:1rem; font-size:0.78rem; color:rgba(255,255,255,0.4); text-align:center;">
                <i class="fa-solid fa-shield-halved"></i>&nbsp; Booking is instant and confirmed immediately
            </div>
        </div>
    </div>
</div>

<script>
// Calculate and update total booking price live
const pricePerSeat = <?php echo $flight['ticket_price']; ?>;
function updateTotal(seats) {
    const n = parseInt(seats) || 0;
    document.getElementById('totalAmount').textContent = 'AED ' + (n * pricePerSeat).toLocaleString();
}
</script>

</body>
</html>
