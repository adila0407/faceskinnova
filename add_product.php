<?php
// Database connection
$servername = "localhost"; // Your database server
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "face_website"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['productName'];
    $category = $_POST['category'];
    $productDesc = $_POST['productDesc'];
    $productPrice = $_POST['productPrice'];
    
    // Handle file upload
    $targetDir = "uploads/"; // Directory to save uploaded files
    $productImage = $targetDir . basename($_FILES["productImage"]["name"]);
    
    if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $productImage)) {
        // Prepare the SQL query
        $sql = "INSERT INTO products (productName, category, productDesc, productPrice, productQuantity, productImage) 
                VALUES ('$productName', '$category', '$productDesc', '$productPrice', $productImage')";

        if ($conn->query($sql) === TRUE) {
            echo "New product added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    $conn->close();
}
?>
