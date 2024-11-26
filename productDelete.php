<?php
// Database connection
$connect = mysqli_connect("localhost", "root", "", "face_website");

if (!$connect) {
    die('ERROR: ' . mysqli_connect_error());
}

// Check if the product ID is provided and is numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Get the product ID from the URL
    $productID = $_GET['id'];

    // Fetch the current details of the product
    $q = "SELECT productName FROM products WHERE id = '$productID'";
    $result = mysqli_query($connect, $q);

    // Check if the product exists
    if (mysqli_num_rows($result) == 1) {
        $product = mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        echo '<p class="error">Product not found.</p>';
        exit();
    }
} else {
    echo '<p class="error">No valid product ID provided.</p>';
    exit();
}

// Handle product deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['sure']) && $_POST['sure'] == 'Yes') {
        // Prepare the DELETE query to remove the product
        $q = "DELETE FROM products WHERE id = '$productID' LIMIT 1";
        $result = mysqli_query($connect, $q);

        // Check if the deletion was successful
        if ($result && mysqli_affected_rows($connect) == 1) {
            echo '<script>
                alert("The product has been deleted.");
                window.location.href="product.php";
                </script>';
        } else {
            echo '<p class="error">The product could not be deleted. It may not exist or there was an error.</p>';
            echo '<p>' . mysqli_error($connect) . '</p>';
        }
    } else {
        // User canceled the deletion
        echo '<script>
            alert("The product has NOT been deleted.");
            window.location.href="product.php";
            </script>';
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
            background: #ffffff;
            padding: 30px 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        form {
            margin-top: 20px;
        }

        input[type="submit"] {
            margin: 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #submit-no {
            background-color: #dc3545;
        }

        #submit-no:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Delete Product</h2>

        <?php
        if (isset($product)) {
            // Display the product name and ask the user if they are sure
            echo '<p>Are you sure you want to delete the product <strong>' . htmlspecialchars($product['productName']) . '</strong>?</p>';
            echo '<form action="productDelete.php?id=' . $productID . '" method="post">
                    <input type="submit" name="sure" value="Yes">
                    <input id="submit-no" type="submit" name="sure" value="No">
                    <input type="hidden" name="id" value="' . $productID . '">
                  </form>';
        } else {
            echo '<p class="error">This page has been accessed in error. Please try again later.</p>';
        }
        ?>

    </div>
</body>
</html>
