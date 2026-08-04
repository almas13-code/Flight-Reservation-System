<?php
include("config.php");
session_start();

$message = "";
$message_type = "";

// Handle user sign in form submission
if (isset($_POST['login'])) {
    $email    = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);
    $sql      = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result   = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id']   = $user['user_id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['email']     = $user['email'];
        header("Location: flights.php");
        exit();
    } else {
        $message      = "Invalid email or password. Please try again.";
        $message_type = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | SkyReserve</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="auth-page">
    <!-- Branding Side Panel -->
    <div class="auth-left">
        <div class="auth-left-content">
            <div class="auth-left-plane">
                <i class="fa-solid fa-plane-departure"></i>
            </div>
            <h2>Welcome Back<br>to SkyReserve</h2>
            <p>Sign in to access your bookings and explore new destinations.</p>

            <div class="auth-pills">
                <div class="auth-pill">
                    <div class="auth-pill-icon"><i class="fa-solid fa-globe"></i></div>
                    50+ routes worldwide
                </div>
                <div class="auth-pill">
                    <div class="auth-pill-icon"><i class="fa-solid fa-clock"></i></div>
                    24/7 flight availability
                </div>
                <div class="auth-pill">
                    <div class="auth-pill-icon"><i class="fa-solid fa-tag"></i></div>
                    Best AED price guaranteed
                </div>
            </div>
        </div>
    </div>

    <!-- Login Form -->
    <div class="auth-right">
        <a href="index.php" class="auth-logo">
            <div class="brand-icon"><i class="fa-solid fa-plane-departure"></i></div>
            SkyReserve
        </a>

        <h2 class="auth-heading">Sign in to your account</h2>
        <p class="auth-subheading">Enter your credentials to access your bookings</p>

        <?php if (!empty($message)): ?>
        <div class="auth-alert auth-alert-<?php echo $message_type; ?>">
            <i class="fa-solid <?php echo $message_type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'; ?>"></i>
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <div class="form-input-wrap">
                    <input type="email" name="email" class="form-input" placeholder="you@example.com" required>
                    <i class="fa-solid fa-envelope"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="form-input-wrap">
                    <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                    <i class="fa-solid fa-key"></i>
                </div>
            </div>

            <button type="submit" name="login" class="btn btn-primary btn-form">
                <i class="fa-solid fa-right-to-bracket"></i> Sign In
            </button>
        </form>

        <div class="auth-switch">
            Don't have an account? <a href="register.php">Create one free &rarr;</a>
        </div>

        <div style="text-align:center; margin-top:1rem;">
            <a href="index.php" style="display:inline-flex; align-items:center; gap:0.4rem; font-size:0.82rem; color:rgba(255,255,255,0.3); text-decoration:none; transition:color 0.2s ease;" onmouseover="this.style.color='rgba(255,255,255,0.7)'" onmouseout="this.style.color='rgba(255,255,255,0.3)'">
                <i class="fa-solid fa-arrow-left" style="font-size:0.72rem;"></i> Back to Home
            </a>
        </div>
    </div>
</div>

</body>
</html>