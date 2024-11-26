<?php
// Database connection
$connect = mysqli_connect("localhost", "root", "", "face_website");

if (!$connect) {
    die('ERROR: ' . mysqli_connect_error());
}

// This query inserts a record in the eLeave table
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = array(); // Initialize an error array

    // Check for adminPassword
    if (empty($_POST['adminPassword'])) {
        $error[] = 'You forgot to enter the password.';
    } else {
        $p = mysqli_real_escape_string($connect, trim($_POST['adminPassword']));
    }

    // Check for adminName
    if (empty($_POST['adminName'])) {
        $error[] = 'You forgot to enter your name.';
    } else {
        $n = mysqli_real_escape_string($connect, trim($_POST['adminName']));
    }

    // Check for adminPhoneNo
    if (empty($_POST['adminPhoneNo'])) {
        $error[] = 'You forgot to enter your phone number.';
    } else {
        $ph = mysqli_real_escape_string($connect, trim($_POST['adminPhoneNo']));
    }

    // Check for adminEmail
    if (empty($_POST['adminEmail'])) {
        $error[] = 'You forgot to enter your email.';
    } else {
        $e = mysqli_real_escape_string($connect, trim($_POST['adminEmail']));
    }

    // If no errors, register the admin in the database
    if (empty($error)) {
        $q = "INSERT INTO admin (adminID, adminPassword, adminName, adminPhoneNo, adminEmail) VALUES (NULL, '$p', '$n', '$ph', '$e')";
        $result = @mysqli_query($connect, $q);

        if ($result) {
            echo '<h1>Thank you for registering!</h1>';
            mysqli_close($connect);
            exit();
        } else {
            echo '<h1>System error</h1>';
            echo '<p>' . mysqli_error($connect) . '<br><br>Query: ' . $q . '</p>';
        }
    }

    mysqli_close($connect);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Admin - Face Skin Nova</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
</head>
<body>

    <div class="container">
        <h2>Register Admin</h2>
        <h4>*Required field</h4>

        <!-- Form for admin registration -->
        <form action="adminSignup.php" method="post">
            
            <!-- Admin Password -->
            <div class="form-group">
                <label for="adminPassword">Password*:</label>
                <input type="password" id="adminPassword" name="adminPassword" pattern="(?=.*\d)(?=.*[A-Z]).{8,}" 
                       title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 characters" 
                       required value="<?php if (isset($_POST['adminPassword'])) echo $_POST['adminPassword']; ?>">
            </div>

            <!-- Admin Name -->
            <div class="form-group">
                <label for="adminName">Admin Name*:</label>
                <input type="text" id="adminName" name="adminName" maxlength="50" required
                       value="<?php if (isset($_POST['adminName'])) echo $_POST['adminName']; ?>">
            </div>

            <!-- Admin Phone Number -->
            <div class="form-group">
                <label for="adminPhoneNo">Phone No.*:</label>
                <input type="tel" id="adminPhoneNo" name="adminPhoneNo" pattern="[0-9]{3}-[0-9]{7}" required
                       value="<?php if (isset($_POST['adminPhoneNo'])) echo $_POST['adminPhoneNo']; ?>">
            </div>

            <!-- Admin Email -->
            <div class="form-group">
                <label for="adminEmail">Admin Email*:</label>
                <input type="email" id="adminEmail" name="adminEmail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required
                       value="<?php if (isset($_POST['adminEmail'])) echo $_POST['adminEmail']; ?>">
            </div>

            <!-- Buttons -->
            <div class="form-buttons">
                <button type="submit">Register</button>
                <button type="reset">Clear All</button>
            </div>
        </form>
    </div>

</body>
</html>

<style>
    /* General body styling */
    body {
        font-family: Arial, sans-serif;
        background-color: #7a7d7e;
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
        background-color: #7a7d7e;
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

    h4 {
        font-size: 14px;
        color: #f44336;
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

    input[type="text"], input[type="email"], input[type="tel"], input[type="password"] {
        width: 100%;
        padding: 12px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type="text"]:focus, input[type="email"]:focus, input[type="tel"]:focus, input[type="password"]:focus {
        border-color: #4CAF50;
        outline: none;
    }

    /* Buttons styling */
    .form-buttons button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 12px 20px;
        text-align: center;
        font-size: 16px;
        margin: 10px 0;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
    }

    .form-buttons button:hover {
        background-color: #45a049;
    }

    .form-buttons button[type="reset"] {
        background-color: #f44336;
    }

    .form-buttons button[type="reset"]:hover {
        background-color: #e53935;
    }

    /* Error message styling */
    .error {
        color: #f44336;
        font-size: 14px;
        margin-top: 10px;
    }

</style>
