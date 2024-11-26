<?php 
// Database connection
$connect = mysqli_connect("localhost", "root", "", "face_website");

if (!$connect) {
    die('ERROR: ' . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    // Get the product ID from the URL
    $productID = $_GET['id'];

    // Fetch the current details of the product
    $q = "SELECT * FROM products WHERE id = '$productID'";
    $result = mysqli_query($connect, $q);

    if (mysqli_num_rows($result) == 1) {
        $product = mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        echo '<p class="error">Product not found.</p>';
        exit();
    }
} else {
    echo '<p class="error">No product ID provided.</p>';
    exit();
}

// Update product details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and escape form inputs
    $productName = mysqli_real_escape_string($connect, $_POST['productName']);
    $category = mysqli_real_escape_string($connect, $_POST['category']);
    $brandCode = mysqli_real_escape_string($connect, $_POST['brandCode']);
    $productDesc = mysqli_real_escape_string($connect, $_POST['productDesc']);
    $productPrice = mysqli_real_escape_string($connect, $_POST['productPrice']);

    // Handle image upload
    $productImage = $product['productImage']; // Keep the current image by default
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0) {
        // Directory where images will be uploaded
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES['productImage']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Allow only specific file formats
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowedExtensions)) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['productImage']['tmp_name'], $targetFile)) {
                $productImage = $targetFile; // Set the new image path
            } else {
                echo '<script>alert("Error uploading image.");</script>';
            }
        } else {
            echo '<script>alert("Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.");</script>';
        }
    }

    // Update query
    $updateQuery = "UPDATE products SET 
                    productName = '$productName', 
                    category = '$category', 
                    brandCode = '$brandCode', 
                    productDesc = '$productDesc', 
                    productPrice = '$productPrice',  
                    productImage = '$productImage' 
                    WHERE id = '$productID'";

    if (mysqli_query($connect, $updateQuery)) {
        echo '<script>alert("Product details updated successfully!"); window.location.href="adminList.php";</script>';
    } else {
        echo '<script>alert("Error updating product details.");</script>';
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product Details</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body */
        body {
            font-family: Arial, sans-serif;
            background-color: #0d466e;
            color: #333;
            line-height: 1.6;
        }

        /* Container for the form */
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            color: #4CAF50;
        }

        /* Form styling */
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Form Group */
        .form-group {
            display: flex;
            flex-direction: column;
        }

        /* Labels */
        label {
            font-weight: bold;
            margin-bottom: 8px;
            color: #4CAF50;
        }

        /* Input and Textarea fields */
        input[type="text"],
        textarea,
        input[type="file"] {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            width: 100%;
        }

        /* Textarea height */
        textarea {
            height: 120px;
        }

        /* Buttons */
        .form-buttons {
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }

        button {
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="reset"] {
            background-color: #f44336;
        }

        button:hover {
            opacity: 0.8;
        }

        a.back-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #2196F3;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            text-align: center;
        }

        a.back-button:hover {
            opacity: 0.8;
        }

        /* Error and success messages */
        .error {
            color: #f44336;
            font-size: 16px;
            text-align: center;
            margin-bottom: 20px;
        }

        .success {
            color: #4CAF50;
            font-size: 16px;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Image Display */
        img {
            max-width: 100px;
            height: auto;
            border-radius: 6px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Update Product Details</h2>

        <!-- Form for updating product details -->
        <form action="productUpdate.php?id=<?php echo $productID; ?>" method="post" enctype="multipart/form-data">
            
            <!-- Product Name -->
            <div class="form-group">
                <label for="productName">Product Name:</label>
                <input type="text" id="productName" name="productName" value="<?php echo $product['productName']; ?>" required>
            </div>

            <!-- Category -->
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" id="category" name="category" value="<?php echo $product['category']; ?>" required>
            </div>

            <!-- Brand Code -->
            <div class="form-group">
                <label for="brandCode">Brand Code:</label>
                <input type="text" id="brandCode" name="brandCode" value="<?php echo $product['brandCode']; ?>" required>
            </div>

            <!-- Product Description -->
            <div class="form-group">
                <label for="productDesc">Description:</label>
                <textarea id="productDesc" name="productDesc" required><?php echo $product['productDesc']; ?></textarea>
            </div>

            <!-- Product Price -->
            <div class="form-group">
                <label for="productPrice">Price:</label>
                <input type="text" id="productPrice" name="productPrice" value="<?php echo $product['productPrice']; ?>" required>
            </div>

            <!-- Product Image (File Upload) -->
            <div class="form-group">
                <label for="productImage">Upload Product Image:</label>
                <input type="file" id="productImage" name="productImage" accept="image/*">
                <!-- Display current image if available -->
                <?php if (!empty($product['productImage'])): ?>
                    <p>Current Image: <img src="<?php echo $product['productImage']; ?>" alt="Product Image" width="100"></p>
                <?php endif; ?>
            </div>

            <!-- Buttons -->
            <div class="form-buttons">
                <button type="submit">Update</button>
                <!-- Back Button -->
                <a href="adminList.php" class="back-button">Back to Product List</a>
            </div>
        </form>
    </div>

</body>
</html>
