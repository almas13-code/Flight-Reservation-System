<?php
// Database connection configuration parameters
$host     = getenv('DB_HOST') ?: "localhost";
$username = getenv('DB_USER') ?: "root";
$password = getenv('DB_PASS') !== false ? getenv('DB_PASS') : "";
$database = getenv('DB_NAME') ?: "flight_reservation_system";

// Establish MySQL database connection
$conn = new mysqli($host, $username, $password, $database);

// Terminate script execution if database connection fails
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>