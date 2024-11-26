<?php
include 'connect.php';

$product_id = $_POST['product_id'];
$description = $_POST['description'];
$price = $_POST['price'];
$category = $_POST['category'];
$product_url = $_POST['product_url'];

// Handle image upload
$image = $_FILES['image']['name'];
$target_dir = "uploads/";
$target_file = $target_dir . basename($image);

if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
    $sql = "UPDATE products SET description='$description', price='$price', category='$category', product_url='$product_url', image_url='$target_file' WHERE id='$product_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Product updated successfully";
    } else {
        echo "Error updating product: " . $conn->error;
    }
} else {
    echo "Error uploading image.";
}

$conn->close();
?>
