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
    if ($result)//if it runs
    {
    	echo '<div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; background-color: #f4f6f9; font-family: Arial, sans-serif; color: #333;">';
              echo '<h2 style="margin-bottom: 20px; font-size: 2em; color: #020b3d;">Thankyou for the feedback!</h2>';
              echo '<a href="index.html"><button style="padding: 12px 25px; font-size: 16px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">Back to Main Page</button></a>';
              echo '</div>';

              echo '<script>
                      const button = document.querySelector("button");
                      button.addEventListener("mouseover", () => {
                          button.style.backgroundColor = "#0056b3";
                      });
                      button.addEventListener("mouseout", () => {
                          button.style.backgroundColor = "#007bff";
                      });
                    </script>';
                    exit();
    }

    // Close the statement
    $stmt->close();
}

// Fetch customer messages
$sql = "SELECT fullName, email, message, inquiryType FROM customer_support";
$result_support = $conn->query($sql);

// Check if query was successful
if ($result_support === false) {
    die("Error: " . $conn->error);
}

// Close the connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Support</title>
    <link rel="shortcut icon" href="images/fav-icon.png"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<style>
/* General Styles */
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #b5bdca;
    padding-top: 80px; /* Adjust this value based on your header height */
}

/* Header Styles */
.header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 30px;
    background-color: #f6cdea;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    width: 100%;
    transition: all 0.3s ease;
}

.logo {
    font-size: 1.8rem;
    font-weight: 800;
    color: #333;
    text-transform: uppercase;
    text-decoration: none;
    display: flex;
    align-items: center;
    margin-right: auto; /* Keeps the logo on the left */
}

.navbar {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 1; /* Takes up the remaining space for centering */
}

.navbar ul {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: space-around; /* Distributes the menu items evenly */
}

.navbar a {
    margin: 0 15px;
    font-size: 1rem;
    color: #555;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.navbar a:hover {
    color: #e91e63;
}

.menu-item {
    position: relative;
    list-style: none;
}

.submenu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: #f8f8f8;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 10px 0;
    min-width: 150px;
    border-radius: 5px;
    z-index: 1;
}

.submenu li a {
    display: block;
    padding: 10px 15px;
    color: #555;
    text-decoration: none;
    font-size: 0.9rem;
}

.submenu li a:hover {
    color: #e91e63;
    background-color: #eee;
}

/* Ensure header stays sticky across all pages */
.header.sticky {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background-color: #f6cdea; /* Adjust header color if needed */
}
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>

     <!-- Header Section -->
    <section id="header" class="header">
    <a href="logo.png" class="logo">Face Skin Nova</a>

        <nav class="navbar">
            <ul>
            <a href="index.html">Home</a>
                <a href="userProducts.php">Product</a>
                <a href="skinType.php">Skin Type</a>
                <a href="reviews.php">Customer experience</a>
                <a href="videoTutorial.html">Video Tutorial</a>
                <a href="customerMessages.php">Customer Support</a>
                <a href="adminLogin.php">Admin</a>
            </ul>
        </nav>
    </section>

<div class="container">
    <h1>Customer Support</h1>

    <!-- Customer inquiry form -->
    <form action="customerSupport.php" method="POST">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="nickname">Nick Name:</label>
        <input type="text" id="nickname" name="nickname" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="phone_number">Phone Number:</label>
        <input type="tel" id="phone_number" name="phone_number" required>

        <label for="inquiry-type">Inquiry Type:</label>
        <select id="inquiry-type" name="inquiry-type" required>
            <option value="Brand Update">Brand Update</option>
            <option value="Skincare Advice">Skincare Advice</option>
            <option value="Others">Others</option>
        </select>

        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="4" required></textarea>

        <button type="submit">Submit Inquiry</button>
    </form>
</div>

</body>
</html>
