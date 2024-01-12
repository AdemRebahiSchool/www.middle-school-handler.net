<?php
session_start();

// Assuming your database is SQLite and located at ../../Database/Pareent/User.db
$databasePath = "../../Database/Pareent/User.db";

// Open the database
$db = new SQLite3($databasePath);

// Get the logged-in user's information
$username = $_SESSION['username'];
$query = $db->prepare("SELECT * FROM users WHERE username = :username");
$query->bindValue(':username', $username, SQLITE3_TEXT);
$result = $query->execute();

// Fetch user information
$userData = $result->fetchArray(SQLITE3_ASSOC);

// Close the database connection
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        nav {
            background-color: #2c3e50;
            padding: 15px;
            color: #ecf0f1;
            text-align: center;
        }

        nav a {
            color: #ecf0f1;
            text-decoration: none;
            padding: 15px;
            margin: 0 10px;
            font-size: 18px;
        }

        nav a:hover {
            background-color: #34495e;
        }

        .dashboard-container {
            padding: 20px;
            margin: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<nav>
    <a href="#">Home</a>
    <a href="#">Profile</a>
    <a href="#">Settings</a>
    <a href="#">Logout</a>
</nav>

<div class="dashboard-container">
    <h1>Welcome to the Dashboard, <?php echo $userData['full_name']; ?>!</h1>
    
    <div>
        <h2>User Information:</h2>
        <p>Username: <?php echo $userData['username']; ?></p>
        <p>Email: <?php echo $userData['email']; ?></p>
        <!-- Add more user information as needed -->
    </div>

    <div>
        <h2>Statistics:</h2>
        <!-- Add more sections or content as needed -->
    </div>
</div>

</body>
</html>
