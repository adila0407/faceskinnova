<?php 
// Database connection
$connect = mysqli_connect("localhost", "root", "", "face_website");

if (!$connect) {
    die('ERROR: ' . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    // Get the admin ID from the URL
    $adminID = $_GET['id'];

    // Fetch the current details of the admin
    $q = "SELECT adminID, adminName, adminPhoneNo, adminEmail FROM admin WHERE adminID = '$adminID'";
    $result = mysqli_query($connect, $q);

    if (mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        echo '<p class="error">Admin not found.</p>';
        exit();
    }
} else {
    echo '<p class="error">No admin ID provided.</p>';
    exit();
}

// Update admin details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate form inputs
    $name = mysqli_real_escape_string($connect, $_POST['adminName']);
    $phoneNo = mysqli_real_escape_string($connect, $_POST['adminPhoneNo']);
    $email = mysqli_real_escape_string($connect, $_POST['adminEmail']);

    // Update query
    $updateQuery = "UPDATE admin SET adminName = '$name', adminPhoneNo = '$phoneNo', adminEmail = '$email' WHERE adminID = '$adminID'";

    if (mysqli_query($connect, $updateQuery)) {
        echo '<script>alert("Admin details updated successfully!"); window.location.href="adminList.php";</script>';
    } else {
        echo '<script>alert("Error updating admin details.");</script>';
    }
}

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Admin Details</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
</head>
<body>

    <div class="container">
        <h2>Update Admin Details</h2>

        <!-- Form for updating admin details -->
        <form action="adminUpdate.php?id=<?php echo $adminID; ?>" method="post">
            
            <!-- Admin Name -->
            <div class="form-group">
                <label for="adminName">Admin Name:</label>
                <input type="text" id="adminName" name="adminName" value="<?php echo $admin['adminName']; ?>" required>
            </div>

            <!-- Admin Phone Number -->
            <div class="form-group">
                <label for="adminPhoneNo">Phone Number:</label>
                <input type="text" id="adminPhoneNo" name="adminPhoneNo" value="<?php echo $admin['adminPhoneNo']; ?>" required>
            </div>

            <!-- Admin Email -->
            <div class="form-group">
                <label for="adminEmail">Email:</label>
                <input type="email" id="adminEmail" name="adminEmail" value="<?php echo $admin['adminEmail']; ?>" required>
            </div>

            <!-- Buttons -->
            <div class="form-buttons">
                <button type="submit">Update</button>
                <button type="reset">Reset</button>
                <!-- Back Button -->
                <a href="adminList.php" class="back-button">Back to Admin List</a>
            </div>
        </form>
    </div>

</body>
</html>

<style>
    /* General body styling */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
        margin: 0;
        padding: 0;
    }

    /* Center the content */
    .container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f4f4f4;
    }

    /* Form container */
    form {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 300px;
        text-align: center;
    }

    /* Title styling */
    h2 {
        color: #333;
        font-size: 24px;
        margin-bottom: 20px;
    }

    /* Error message styling */
    .error {
        color: #f44336;
        font-size: 14px;
        margin-top: 10px;
        text-align: center;
    }

    /* Form input fields */
    .form-group {
        margin: 10px 0;
        text-align: left;
        width: 100%;
    }

    label {
        font-size: 14px;
        margin-bottom: 5px;
    }

    input[type="text"], input[type="email"] {
        width: 100%;
        padding: 12px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type="text"]:focus, input[type="email"]:focus {
        border-color: #4CAF50;
        outline: none;
    }

    /* Buttons styling */
    .form-buttons button, .back-button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 12px;
        text-align: center;
        font-size: 16px;
        margin: 8px 0;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        text-decoration: none;
        display: inline-block;
    }

    /* Ensure all buttons are the same size */
    .form-buttons button {
        width: 100%;
    }

    /* Hover effects for buttons */
    .form-buttons button:hover, .back-button:hover {
        background-color: #45a049;
    }

    .form-buttons button[type="reset"] {
        background-color: #f44336;
    }

    .form-buttons button[type="reset"]:hover {
        background-color: #e53935;
    }

    /* Back button styling */
    .back-button {
        background-color: #2196F3;
    }

    .back-button:hover {
        background-color: #0b7dda;
    }
</style>
