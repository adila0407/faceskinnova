<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "face_website";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success_message = "";

// Submit review
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_review'])) {
    $name = htmlspecialchars($_POST['name']);
    $review_text = htmlspecialchars($_POST['review_text']);

    // Insert review into database
    $sql = "INSERT INTO reviews (name, review_text) VALUES ('$name', '$review_text')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "New review submitted successfully."; // Set the success message
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Retrieve reviews from the database
$sql = "SELECT name, review_text, created_at FROM reviews ORDER BY created_at DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Face Skin Nova</title>
    <link rel="stylesheet" href="css/style.css"/>
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

.container {
    width: 80%;
    margin: 0 auto;
    padding: 40px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #5f6368;
}

.submit-review form {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-bottom: 40px;
}

.submit-review input, .submit-review textarea {
    padding: 10px;
    font-size: 16px;
    border-radius: 5px;
    border: 1px solid #ddd;
}

.submit-review button {
    padding: 10px;
    font-size: 16px;
    background-color: #76b041;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.submit-review button:hover {
    background-color: #64a237;
}

.customer-reviews {
    margin-top: 40px;
}

.review {
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.review-text {
    font-size: 16px;
    color: #555;
}

.review-author {
    font-weight: 600;
    color: #333;
}

.review-date {
    font-size: 14px;
    color: #777;
}

/* Back button styling */
.back-button {
    display: inline-block;
    margin: 20px 0;
    padding: 10px 20px;
    background-color: #76b041;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
}

.back-button:hover {
    background-color: #64a237;
}
</style>
<body>

  <div class="container">
    <h1>Customer Experience / Reviews </h1>

    <!-- Back Button -->
    <a href="index.html" class="back-button">Back to Home</a>

    <!-- Review Submission Form -->
    <section class="submit-review">
      <h2>Share Your Review</h2>
      <form action="reviews.php" method="POST">
        <input type="text" name="name" placeholder="Your Name" required>
        <textarea name="review_text" placeholder="Write your review..." required></textarea>
        <button type="submit" name="submit_review">Submit Review</button>
      </form>
    </section>

    <!-- Display Reviews -->
    <section class="customer-reviews">
      <h2>Recent Reviews</h2>

      <?php
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              echo '<div class="review">';
              echo '<p class="review-text">' . htmlspecialchars($row['review_text']) . '</p>';
              echo '<div class="review-author">- ' . htmlspecialchars($row['name']) . ' <span class="review-date">on ' . $row['created_at'] . '</span></div>';
              echo '</div>';
          }
      } else {
          echo "No reviews yet.";
      }
      ?>

    </section>
  </div>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
