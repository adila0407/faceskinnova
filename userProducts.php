<?php
// userProducts.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "face_website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get search input from form
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$category = isset($_GET['category']) ? $_GET['category'] : 'all';

// Construct the SQL query based on search or category
if (!empty($search)) {
    $sql = "SELECT * FROM products WHERE productName LIKE '%$search%' OR category LIKE '%$search%'";
} else {
    if ($category == 'all') {
        $sql = "SELECT * FROM products";
    } else {
        $sql = "SELECT * FROM products WHERE category = '$category'";
    }
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Face Skin Nova</title>
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

        /* Category Filter */
        #category-filter {
            margin-top: 140px; /* Ensure there is enough space from the fixed header */
        }

        .category-filter {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            flex-wrap: wrap; /* Allow the buttons to wrap on smaller screens */
        }

        .category-filter button {
            margin: 5px 15px;
            background-color: #5c6bc0;
            color: white;
            border: none;
            padding: 15px 25px; /* Adjusted padding for better button size */
            cursor: pointer;
            border-radius: 8px; /* Slightly round edges for a smoother look */
            font-size: 1.1rem; /* Slightly larger text */
            transition: background-color 0.3s ease, transform 0.2s ease; /* Added smooth hover effect */
        }

        .category-filter button:hover {
            background-color: #3f51b5;
            transform: scale(1.05); /* Slight scale effect on hover */
        }

        /* Product Styles */
        .container {
            padding: 50px 15px;
        }

        .product-box {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-top: 30px;
        }

        .product-card {
            width: 250px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: white;
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-img img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-bottom: 2px solid #f1f1f1;
        }

        .product-text {
            padding: 15px;
            text-align: center;
        }

        .product-text span {
            display: block;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .product-text a {
            font-size: 1.1rem;
            color: #5c6bc0;
            text-decoration: none;
            margin-bottom: 10px;
            display: block;
        }

        /* Additional Image Gallery Styles */
        .additional-images {
            margin-top: 50px;
            padding: 30px 0;
            background-color: #f1f1f1;
        }

        .additional-images h3 {
            text-align: center;
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #333;
        }

        .image-gallery {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .gallery-image {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .gallery-image:hover {
            transform: scale(1.05);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            overflow: auto;
            padding-top: 60px;
        }

        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 20px;
            border-radius: 8px;
            width: 80%;
            max-width: 500px;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 30px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Footer Styles */
        footer {
            text-align: center;
            padding: 20px;
            background-color: #f6cdea;
            margin-top: 50px;
        }

        footer p {
            color: #333;
        }
    </style>
</head>
<body>

<!-- Header Section -->
<section id="header" class="header">
<a href="logo.png" class="logo">Face Skin Nova</a>
    <nav class="navbar">
        <ul><a href="index.html">Home</a>
                <a href="userProducts.php">Product</a>
                <a href="skinType.php">Skin Type</a>
                <a href="reviews.php">Review your experience</a>
                <a href="videoTutorial.html">Video Tutorial</a>
                <a href="customerMessages.php">Customer Support</a>
                <a href="adminLogin.php">Admin</a>
        </ul>
    </nav>
</section>

<!-- Search Bar Section -->
<section id="search-bar">
    <div style="text-align: center; margin-top: 20px;">
        <form action="userProducts.php" method="GET">
            <input type="text" name="search" placeholder="Search by name or category..." value="<?php echo htmlspecialchars($search); ?>" style="padding: 10px; width: 300px;"/>
            <button type="submit" style="padding: 10px;">Search</button>
        </form>
    </div>
</section>

<!-- Category Filter Section -->
<section id="category-filter">
    <div class="category-filter">
        <a href="userProducts.php?category=all"><button>All</button></a>
        <a href="userProducts.php?category=Cleanser"><button>Cleanser</button></a>
        <a href="userProducts.php?category=Serum"><button>Serum</button></a>
        <a href="userProducts.php?category=Moisturizer"><button>Moisturizer</button></a>
        <a href="userProducts.php?category=Sunscreen"><button>Sunscreen</button></a>
        <a href="userProducts.php?category=Acne"><button>Acne</button></a>
        <a href="userProducts.php?category=Darkspot"><button>Darkspot</button></a>
    </div>
</section>

<!-- Products Section -->
<section id="products">
    <div class="container">
        <h3>Skincare Products For You</h3>
        <div class="product-box">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product-card">
                            <div class="product-img">
                                <img src="' . htmlspecialchars($row['productImage']) . '" alt="' . htmlspecialchars($row['productName']) . '">
                            </div>
                            <div class="product-text">
                                <span>' . htmlspecialchars($row['productName']) . '</span>
                                <p>' . htmlspecialchars($row['productDesc']) . '</p>
                                <p>Price: RM ' . number_format($row['productPrice'], 2) . '</p>
                                <a href="javascript:void(0);" onclick="showModal(\'' . addslashes($row['productName']) . '\', \'' . addslashes($row['productDesc']) . '\', \'' . number_format($row['productPrice'], 2) . '\', \'' . htmlspecialchars($row['productImage']) . '\', \'' . addslashes($row['ingredients']) . '\')">View Details</a>
                            </div>
                        </div>';
                }
            } else {
                echo "No products found.";
            }
            $conn->close();
            ?>
        </div>
    </div>
</section>

<!-- Additional Image Section Before Footer -->
<section id="additional-images" class="additional-images">
    <div class="container">
        <h3>Before and after using product </h3>
        <div class="image-gallery">
            <img src="pic1.jpg" alt="Product 1" class="gallery-image">
            <img src="p2.jpg" alt="Product 2" class="gallery-image">
            <img src="pic3.jpg" alt="Product 3" class="gallery-image">
            <img src="pic4.jpg" alt="Product 4" class="gallery-image">
        </div>
    </div>
</section>

<!-- Footer Section -->
<footer>
    <p>&copy; 2024 Face Skin Nova. All Rights Reserved.</p>
</footer>

<!-- Modal HTML -->
<div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2 id="modalProductName"></h2>
        <img id="modalProductImage" src="" alt="" style="width: 100%; height: auto; border-radius: 8px;"/>
        <p id="modalProductDesc"></p>
        <p><strong>Price: RM <span id="modalProductPrice"></span></strong></p>
        <p><strong>Ingredients: <span id="modalProductIngredients"></span></strong></p>
    </div>
</div>

<script>
    // Function to open the modal and show product details
    function showModal(name, desc, price, image, ingredients) {
        document.getElementById("modalProductName").textContent = name;
        document.getElementById("modalProductDesc").textContent = desc;
        document.getElementById("modalProductPrice").textContent = price;
        document.getElementById("modalProductImage").src = image;
        document.getElementById("modalProductIngredients").textContent = ingredients;
        document.getElementById("productModal").style.display = "block";
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById("productModal").style.display = "none";
    }

    // Close the modal if the user clicks outside of the modal content
    window.onclick = function(event) {
        if (event.target == document.getElementById("productModal")) {
            closeModal();
        }
    }
</script>

</body>
</html>
