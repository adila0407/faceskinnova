<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "face_website";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Search functionality
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

// Query to retrieve admin details
$sql_admin = "SELECT adminID, adminPassword, adminName, adminPhoneNo, adminEmail FROM admin ORDER BY adminID";
$result_admin = $conn->query($sql_admin);

// Check for errors
if ($result_admin === false) {
    die("Error executing query for admins: " . $conn->error);
}

// Fetch customer support messages
$sql_messages_support = "SELECT fullName, email, message, inquiryType FROM customer_support";
$result_messages_support = $conn->query($sql_messages_support);

// Check if the query was successful
if ($result_messages_support === false) {
    die("Error executing query for customer support message: " . $conn->error);
}

// Fetch reviews
$sql_reviews = "SELECT id, name, review_text, created_at FROM reviews";
$result_reviews = $conn->query($sql_reviews);

// Check if the query was successful
if ($result_reviews === false) {
    die("Error executing query for customer reviews: " . $conn->error);
}

// Fetch products based on search query
$sql_products = "SELECT * FROM products";
if (!empty($search_query)) {
    $sql_products .= " WHERE productName LIKE '%" . $conn->real_escape_string($search_query) . "%'";
}
$result_products = $conn->query($sql_products);

// Check if the query was successful
if ($result_products === false) {
    die("Error executing query for products: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Face Skin Nova Admin Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #b5bdca;
            padding: 20px;
            margin: 0;
            color: #333;
        }

        header {
            background-color: #f6cdea;
            color: black; /* Changed to black */
            text-align: center;
            padding: 20px;
            font-size: 24px;
        }

        nav {
            background-color: #333;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 15px 20px;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #575757;
            color: #fff;
        }

        h2 {
            margin: 20px 0;
            color: #444;
        }

        .container {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            background-color: #f6cdea;
            color: #333;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #d987a5;
            color: white;
        }

        table tr:hover {
            background-color: #e8b0c7;
        }

        table a {
            color: #0044cc;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        table a:hover {
            background-color: #0044cc;
            color: white;
        }

        .search-bar {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-bar input[type="text"] {
            padding: 10px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .search-bar button {
            padding: 10px 15px;
            border: none;
            background-color: #0044cc;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #002a80;
        }

        .error {
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<header>
    <h1>Face Skin Nova - Admin Dashboard</h1>
</header>

<!-- Navigation Bar -->
<nav>
    <a href="#adminList">Admin</a>
    <a href="#products">Product List</a>
    <a href="#messages">Customer Messages</a>
    <a href="#experience">Customer Experience</a>
    <a href="product.php">Add Product</a>
    <a href="logout.php" onclick="return confirmLogout();">Logout</a>
</nav>

<div class="container">
    <!-- Admin List -->
    <h2 id="adminList">List of Admins</h2>

    <?php
    if ($result_admin->num_rows > 0) {
        echo '<table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone No.</th>
                    <th>Email</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>';

        while ($row = $result_admin->fetch_assoc()) {
            echo '<tr>
                <td>' . $row['adminID'] . '</td>
                <td>' . $row['adminName'] . '</td>
                <td>' . $row['adminPhoneNo'] . '</td>
                <td>' . $row['adminEmail'] . '</td>
                <td><a href="adminUpdate.php?id=' . $row['adminID'] . '">Update</a></td>
                <td><a href="adminDelete.php?id=' . $row['adminID'] . '">Delete</a></td>
            </tr>';
        }

        echo '</tbody></table>';
    } else {
        echo '<p class="error">No admin records found.</p>';
    }
    ?>

    <!-- Product List -->
    <h2 id="products">List of Products</h2>
    
    <!-- Search Bar -->
    <div class="search-bar">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Search product..." value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <?php
    if ($result_products->num_rows > 0) {
        echo '<table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Brand Code</th>
                    <th>Price (RM)</th>
                    <th>Image</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>';

        while ($row = $result_products->fetch_assoc()) {
            echo '<tr>
                <td>' . $row['productName'] . '</td>
                <td>' . $row['category'] . '</td>
                <td>' . $row['brandCode'] . '</td>
                <td>' . $row['productPrice'] . '</td>
                <td><img src="' . $row['productImage'] . '" alt="Product Image" style="width: 50px; height: 50px;"></td>
                <td><a href="productUpdate.php?id=' . $row['id'] . '">Update</a></td>
                <td><a href="productDelete.php?id=' . $row['id'] . '">Delete</a></td>
            </tr>';
        }

        echo '</tbody></table>';
    } else {
        echo '<p class="error">No products found.</p>';
    }
    ?>

    <!-- Customer Support Messages -->
    <h2 id="messages">Customer Support Messages</h2>

    <?php
    if ($result_messages_support->num_rows > 0) {
        echo '<table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Inquiry Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>';

        while ($row = $result_messages_support->fetch_assoc()) {
            echo '<tr>
                <td>' . $row['fullName'] . '</td>
                <td>' . $row['email'] . '</td>
                <td>' . $row['message'] . '</td>
                <td>' . $row['inquiryType'] . '</td>
                <td><a href="deleteMessage.php?email=' . $row['email'] . '">Delete</a></td>
            </tr>';
        }

        echo '</tbody></table>';
    } else {
        echo '<p class="error">No customer support messages found.</p>';
    }
    ?>

    <!-- Customer Experience -->
<h2 id="experience">Customer Experience</h2>

<?php
if ($result_reviews->num_rows > 0) {
    echo '<table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Review</th>
                <th>Date & Time</th>
                <th>Actions</th> <!-- Added Actions column for delete -->
            </tr>
        </thead>
        <tbody>';

    while ($row = $result_reviews->fetch_assoc()) {
        echo '<tr>
            <td>' . $row['name'] . '</td>
            <td>' . $row['review_text'] . '</td>
            <td>' . $row['created_at'] . '</td>
            <td><a href="deleteReviews.php?id=' . $row['id'] . '">Delete</a></td> <!-- Added delete button -->
        </tr>';
    }

    echo '</tbody></table>';
} else {
    echo '<p class="error">No customer reviews found.</p>';
}
?>

</div>

<!-- Logout Confirmation Script -->
<script>
    function confirmLogout() {
        return confirm("Are you sure you want to logout?");
    }
</script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
