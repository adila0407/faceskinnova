<?php
// Database connection
$servername = "localhost"; // Your database host
$username = "root";        // Your database username
$password = "";            // Your database password
$dbname = "face_website";   // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products based on category
$category = isset($_GET['category']) ? $_GET['category'] : 'all';

// SQL query to fetch products based on the selected category
$sql = "SELECT * FROM products";
if ($category != 'all') {
    $sql .= " WHERE category = '$category'";
}

$result = $conn->query($sql);

// Check if there are products
$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJxv3Ot6+FfS8Cq1RkQ1fpf/j5V+2Y4LRh19EJ8u3bz9MY36VoCEWxZgAdGg" crossorigin="anonymous">
    <style>
        /* Custom Styles (same as before) */
        /*...*/
    </style>
</head>
<body>

    <div class="container">
        <!-- New Products Section -->
        <section id="new_products">
            <div class="new-p-heading">
                <h3>Basic Products For You</h3>
                <!-- Filter List -->
                <ul>
                    <li class="active" data-filter="all"><a href="index.php?category=all">All</a></li>
                    <li data-filter="Cleanser"><a href="index.php?category=Cleanser">Cleanser</a></li>
                    <li data-filter="Serum"><a href="index.php?category=Serum">Serum</a></li>
                    <li data-filter="Moisturizer"><a href="index.php?category=Moisturizer">Moisturizer</a></li>
                    <li data-filter="Sunscreen"><a href="index.php?category=Sunscreen">Sunscreen</a></li>
                </ul>
            </div>

            <!-- Container -->
            <div class="new-product-container">
                <?php
                if (!empty($products)) {
                    foreach ($products as $product) {
                        echo '<div class="new-product-box" data-label="' . $product['category'] . '">
                            <div class="new-product-img">
                                <img src="' . $product['image_url'] . '" alt="' . $product['name'] . '">
                            </div>
                            <div class="new-product-text">
                                <span>RM' . number_format($product['price'], 2) . '</span>
                                <a href="#">' . $product['name'] . '</a>
                                <div class="show-details-button">
                                    <a href="' . $product['product_url'] . '" class="btn">View</a>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    echo "<p>No products found for the selected category.</p>";
                }
                ?>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0WG8NfJ6V10SKbXDi6tJ+dVgkdlX6R+zD6dTpI9g9CHu1bD2" crossorigin="anonymous"></script>
</body>
</html>
