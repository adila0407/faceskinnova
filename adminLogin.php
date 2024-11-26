<?php
// Database connection
$connect = mysqli_connect("localhost", "root", "", "face_website");

if (!$connect) {
    die('ERROR: ' . mysqli_connect_error());
}

// This section processes submission from the login form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate the adminID
    if (!empty($_POST['adminID'])) {
        $id = mysqli_real_escape_string($connect, $_POST['adminID']);
    } else {
        $id = FALSE;
        $error_message = "You forgot to enter your ID.";
    }

    // Validate the adminPassword
    if (!empty($_POST['adminPassword'])) {
        $p = mysqli_real_escape_string($connect, $_POST['adminPassword']);
    } else {
        $p = FALSE;
        $error_message = "You forgot to enter your password.";
    }

    // If no problems
    if ($id && $p) {
        // Retrieve the adminID, adminPassword, adminName, adminPhoneNo, adminEmail
        $q = "SELECT adminID, adminPassword, adminName, adminPhoneNo, adminEmail FROM admin WHERE (adminID = '$id' AND adminPassword = '$p')";

        // Run the query and assign it to the variable $result
        $result = mysqli_query($connect, $q);

        // Count the number of rows that match the adminID/adminPassword combination
        if (@mysqli_num_rows($result) == 1) {
            // Start the session, fetch the record, and insert the values in an array
            session_start();
            $_SESSION = mysqli_fetch_array($result, MYSQLI_ASSOC);
            
            // Free the result and close the connection
            mysqli_free_result($result);
            mysqli_close($connect);

            // JavaScript to show success message
            echo '<script>alert("Login successful! Welcome to Admin Dashboard Face Skin Nova."); window.location.href="adminList.php";</script>';
            exit();
        } else {
            // JavaScript to show error message
            $error_message = "Unsuccessful. Login Again.";
        }
    } else {
        $error_message = "Please try again.";
    }

    // Show the error message in a pop-up
    if (isset($error_message)) {
        echo '<script>alert("' . $error_message . '");</script>';
    }

    // Close the connection
    mysqli_close($connect);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to the CSS file -->
</head>
<style>
    /* General body styling */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #7a7d7e;
        margin: 0;
        padding: 0;
    }

    /* Center the content */
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    /* Form container */
    form {
        background-color: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        text-align: center;
        box-sizing: border-box;
    }

    /* Title styling */
    h2 {
        font-size: 26px;
        color: #333;
        margin-bottom: 20px;
        font-weight: bold;
    }

    /* Input fields */
    input[type="text"], input[type="password"] {
        width: 100%;
        padding: 15px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
        box-sizing: border-box;
        background-color: #f9f9f9;
    }

    /* Focused input field styling */
    input[type="text"]:focus, input[type="password"]:focus {
        border-color: #4CAF50;
        outline: none;
        background-color: #e8f5e9;
    }

    /* Buttons */
    button {
        width: 100%;
        padding: 15px;
        margin: 10px 0;
        background-color: #4e727e;
        color: white;
        font-size: 18px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    /* Button hover effect */
    button:hover {
        background-color: #45a049;
    }

    /* Reset button styling */
    button[type="reset"] {
        background-color: #f44336;
    }

    button[type="reset"]:hover {
        background-color: #e53935;
    }

    /* Link styling */
    a {
        color: #4CAF50;
        text-decoration: none;
        font-size: 14px;
    }

    a:hover {
        text-decoration: underline;
    }

    /* Error message styling */
    .error {
        color: #f44336;
        font-size: 14px;
        margin-top: 10px;
    }

    /* Mobile responsiveness */
    @media (max-width: 500px) {
        .container {
            padding: 0 10px;
        }

        form {
            padding: 20px;
        }

        h2 {
            font-size: 22px;
        }
    }
</style>

<body>
    <div class="container">
        <form action="adminLogin.php" method="post">
            <h2>Admin Login</h2>

            <div>
                <label for="adminID">Admin ID:</label>
                <input type="text" id="adminID" name="adminID" size="4" maxlength="6"
                       value="<?php if (isset($_POST['adminID'])) echo $_POST['adminID']; ?>" required>
            </div>

            <div>
                <label for="adminPassword">Password:</label>
                <input type="password" id="adminPassword" name="adminPassword" size="15" maxlength="60"
                       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required
                       value="<?php if (isset($_POST['adminPassword'])) echo $_POST['adminPassword']; ?>">
            </div>

            <div>
                <button type="submit">Login</button>
                <button type="reset">Reset</button>
            </div>
            <div>
                <label>Don't have an account? <a href="adminSignup.php">Sign Up</a></label>
            </div>
        </form>
    </div>
</body>
</html>
