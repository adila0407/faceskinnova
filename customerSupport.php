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

// Now you can safely use $conn throughout your script, including preparing statements.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fullName = $_POST['name'];
    $nickName = $_POST['nickname'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $inquiryType = $_POST['inquiry-type'];
    $message = $_POST['message'];

    // Prepare the SQL statement to prevent SQL injection
    if ($stmt = $conn->prepare("INSERT INTO customer_support (fullName, nickName, email, phoneNumber, message, inquiryType) VALUES (?, ?, ?, ?, ?, ?)")) {
        $stmt->bind_param("ssssss", $fullName, $nickName, $email, $phoneNumber, $message, $inquiryType);

        // Execute the query and check if it was successful
        if ($stmt->execute()) {
            echo "<script>alert('Your inquiry has been submitted successfully.');</script>";
        } else {
            echo "<script>alert('There was an error submitting your inquiry. Please try again later.'); window.location.href = 'customerList.php';</script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        // Handle case where the statement preparation fails
        echo "<script>alert('Failed to prepare the SQL statement.');</script>";
    }
}

// Fetch customer messages
$sql = "SELECT fullName, email, message, inquiryType FROM customer_support";
$result_support = $conn->query($sql);

// Check if query was successful
if ($result_support === false) {
    die("Error: " . $conn->error);
}

// Close the connection after everything is done
$conn->close();
?>