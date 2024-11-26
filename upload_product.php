<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "face_website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $productName = !empty($_POST['productName']) ? $_POST['productName'] : null;
    $category = !empty($_POST['category']) ? $_POST['category'] : null;
    $brandCode = !empty($_POST['brandCode']) ? $_POST['brandCode'] : null;
    $productDesc = !empty($_POST['productDesc']) ? $_POST['productDesc'] : null;
    $productPrice = isset($_POST['productPrice']) && is_numeric($_POST['productPrice']) ? $_POST['productPrice'] : null;

    // Check if all required fields are filled
    if (!$productName || !$category || !$brandCode || !$productDesc || !$productPrice) {
        echo "All fields are required and product price must be valid.";
        exit;
    }

    // Validate product price (must be positive)
    if ($productPrice <= 0) {
        echo "Product price must be a valid positive number.";
        exit;
    }

    // Use absolute path for the uploads directory
    $targetDir = __DIR__ . "/uploads/"; // Absolute path to the uploads folder
    $targetFile = $targetDir . basename($_FILES["productImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if uploads directory exists and is writable
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true); // Create the directory if it doesn't exist
    }

    if (!is_writable($targetDir)) {
        echo "Uploads directory is not writable.";
        exit;
    }

    // Check if file is an image
    $check = getimagesize($_FILES["productImage"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES["productImage"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" &&
        $imageFileType != "png" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // If everything is ok, try to upload file
    if ($uploadOk == 1) {
        // Rename the file to avoid conflicts
        $newFileName = uniqid('prod_', true) . '.' . $imageFileType;
        $targetFile = $targetDir . $newFileName;

        if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile)) {
            // Prepare SQL statement for inserting the product into the database (removed productQuantity and created_at)
            $sql = "INSERT INTO products (productName, category, brandCode, productDesc, productPrice, productImage)
                    VALUES (?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssdss", $productName, $category, $brandCode, $productDesc, $productPrice, $targetFile);

            if ($stmt->execute()) {
                echo "New product uploaded successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>
