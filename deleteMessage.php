<?php
// Database connection
$servername = "localhost"; // Update with your database host
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "face_website"; // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch email from URL
$email = $_GET['id']; // Get the email parameter from the URL

// Prepare SQL to delete the message
$sql_delete = "DELETE FROM customer_support WHERE email = ?";
$stmt_delete = $conn->prepare($sql_delete);

// Check if the delete query preparation is successful
if (!$stmt_delete) {
    die("Error preparing delete SQL statement: " . $conn->error);
}

// Bind the email parameter to the prepared statement
$stmt_delete->bind_param("s", $email);

// Execute the query
if ($stmt_delete->execute()) {
    echo "<script>
            alert('Message deleted successfully.');
            window.location.href = 'adminList.php'; // Redirect to the admin dashboard
          </script>";
} else {
    echo "<script>
            alert('Error deleting message: " . $conn->error . "');
            window.location.href = 'adminList.php'; // Redirect to the admin dashboard even in case of error
          </script>";
}

// Close the prepared statement and connection
$stmt_delete->close();
$conn->close();
?>
