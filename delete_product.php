<?php
include 'connect.php';

$product_id = $_POST['product_id'];

$sql = "DELETE FROM products WHERE id='$product_id'";

if ($conn->query($sql) === TRUE) {
    echo "Product deleted successfully";
} else {
    echo "Error deleting product: " . $conn->error;
}

$conn->close();
?>
