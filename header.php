<?php
// connection.php example
$servername = "localhost"; // Your database server, usually "localhost"
$username = "root";        // Your database username, commonly "root" in XAMPP
$password = "";            // Your database password, blank for XAMPP default
$dbname = "face_website"; // Replace with your database name

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

    if ($conn) {
    // Your prepared statement code
} else {
    die("Database connection error. Please check your connection settings.");
}
}
?>
