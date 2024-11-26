<?php
// Start the session to check if the admin is logged in
session_start();

// Check if the admin is logged in (You can replace this with your own login check)
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: adminLogin.php'); // Redirect to login if not logged in
    exit;
}

// Database connection
$connect = mysqli_connect("localhost", "root", "", "face_website");

if (!$connect) {
    die('ERROR: ' . mysqli_connect_error());
}

// Fetch the list of admins
$q = "SELECT adminID, adminName, adminPhoneNo, adminEmail FROM admin ORDER BY adminID";
$result = mysqli_query($connect, $q);

if (!$result) {
    die('ERROR: ' . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin List Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background-color: #f4f4f9;
        }

        /* Dashboard Layout */
        .dashboard-container {
            display: flex;
            flex-direction: column;
            padding: 20px;
            height: 100vh;
        }

        /* Header */
        .header {
            background-color: #2c3e50;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        /* Admin List Section */
        .admin-list-box {
            background-color: white;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .admin-list-box h2 {
            color: #333;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #f7f7f7;
        }

        .logout {
            color: #2c3e50;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin-top: 20px;
            padding: 10px;
            background-color: #ecf0f1;
            border-radius: 5px;
        }

        .logout:hover {
            background-color: #34495e;
            color: white;
        }

    </style>
</head>
<body>

<div class="dashboard-container">
    <div class="header">
        <h1>Admin List Dashboard</h1>
    </div>

    <div class="admin-list-box">
        <h2>List of Admins</h2>

        <?php
        if (mysqli_num_rows($result) > 0) {
            echo '<table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone No.</th>
                <th>Email</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>';

            // Fetch and print all the records
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo '<tr>
                    <td>' . $row['adminID'] . '</td>
                    <td>' . $row['adminName'] . '</td>
                    <td>' . $row['adminPhoneNo'] . '</td>
                    <td>' . $row['adminEmail'] . '</td>
                    <td align="center"><a href="adminUpdate.php?id=' . $row['adminID'] . '">Update</a></td>
                    <td align="center"><a href="adminDelete.php?id=' . $row['adminID'] . '">Delete</a></td>
                </tr>';
            }

            echo '</table>';
        } else {
            echo '<p>No admin records found.</p>';
        }

        // Free up the resources
        mysqli_free_result($result);
        // Close the database connection
        mysqli_close($connect);
        ?>

        <!-- Logout link -->
        <a href="adminLogin.php" class="logout">Logout</a>
    </div>
</div>

</body>
</html>
