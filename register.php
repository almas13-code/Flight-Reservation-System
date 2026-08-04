<?php
include("config.php");

$message = "";
$message_type = "";

// Handle new user registration form submission
if (isset($_POST['register'])) {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email     = $conn->real_escape_string($_POST['email']);
    $password  = $conn->real_escape_string($_POST['password']);

    $sql = "INSERT INTO users(full_name, email, password) VALUES('$full_name', '$email', '$password')";
    if ($conn->query($sql)) {
        $message      = "Account created successfully! You can now sign in.";
        $message_type = "success";
    } else {
        $message      = "Registration failed. Email may already be registered.";
        $message_type = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | SkyReserve</title>
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
            <h2>Join SkyReserve<br>Today</h2>
            <p>Your gateway to seamless flight bookings across the globe.</p>

            <div class="auth-pills">
                <div class="auth-pill">
                    <div class="auth-pill-icon"><i class="fa-solid fa-bolt"></i></div>
                    Real-time flight availability
                </div>
                <div class="auth-pill">
                    <div class="auth-pill-icon"><i class="fa-solid fa-shield-halved"></i></div>
                    Secure & encrypted accounts
                </div>
                <div class="auth-pill">
                    <div class="auth-pill-icon"><i class="fa-solid fa-ticket"></i></div>
                    Instant booking confirmation
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Form -->
    <div class="auth-right">
        <a href="index.php" class="auth-logo">
            <div class="brand-icon"><i class="fa-solid fa-plane-departure"></i></div>
            SkyReserve
        </a>

        <h2 class="auth-heading">Create your account</h2>
        <p class="auth-subheading">Fill in your details to get started</p>

        <?php if (!empty($message)): ?>
        <div class="auth-alert auth-alert-<?php echo $message_type; ?>">
            <i class="fa-solid <?php echo $message_type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'; ?>"></i>
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <div class="form-input-wrap">
                    <input type="text" name="full_name" class="form-input" placeholder="John Doe" required>
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>

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
                    <input type="password" name="password" class="form-input" placeholder="Create a strong password" required>
                    <i class="fa-solid fa-key"></i>
                </div>
            </div>

            <button type="submit" name="register" class="btn btn-primary btn-form">
                <i class="fa-solid fa-user-check"></i> Create Account
            </button>
        </form>

        <div class="auth-switch">
            Already have an account? <a href="login.php">Sign in &rarr;</a>
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