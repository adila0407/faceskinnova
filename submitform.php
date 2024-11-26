<?php
// Database connection
$servername = "localhost"; // Change to your database host
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "face_website"; // The name of the database you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fullName = $_POST['name'];
    $nickName = $_POST['nickname'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'];
    $inquiryType = $_POST['inquiry-type'];
    $message = $_POST['message'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO customer_support (fullName, nickName, email, phoneNumber, message, inquiryType) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $fullName, $nickName, $email, $phoneNumber, $message, $inquiryType);

    // Execute the query and check if it was successful
    if ($stmt->execute()) {
        // Redirect to a thank-you page or display a success message
        echo "<script>alert('Your inquiry has been submitted successfully.'); </script>";
    } else {
        echo "<script>alert('There was an error submitting your inquiry. Please try again later.'); window.location.href = 'index.html';</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
