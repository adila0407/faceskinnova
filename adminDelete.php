<?php
// Database connection
$connect = mysqli_connect("localhost", "root", "", "face_website");

if (!$connect) {
    die('ERROR: ' . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    // Get the admin ID from the URL
    $adminID = $_GET['id'];

    // Delete query
    $deleteQuery = "DELETE FROM admin WHERE adminID = '$adminID'";

    if (mysqli_query($connect, $deleteQuery)) {
        echo '<script>alert("Admin deleted successfully!"); window.location.href="adminList.php";</script>';
    } else {
        echo '<script>alert("Error deleting admin."); window.location.href="adminList.php";</script>';
    }
}

mysqli_close($connect);
?>
