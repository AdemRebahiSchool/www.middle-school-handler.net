<?php
// Assuming your database is SQLite and located at ../../Database/Eleve/User.db
$databasePath = "../../Database/Pareent/User.db";

// Get the posted data
$username = $_POST['username'];
$password = $_POST['password'];

// Open the database
$db = new SQLite3($databasePath);

// Check if the username and password match
$query = $db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
$query->bindValue(':username', $username, SQLITE3_TEXT);
$query->bindValue(':password', $password, SQLITE3_TEXT);
$result = $query->execute();

// If a match is found, redirect to the dashboard
if ($row = $result->fetchArray()) {
    session_start();
    $_SESSION['username'] = $username;
    header("Location: Dashboard/dashboard.php");
} else {
    // If no match, redirect back to the login page
    header("Location: login.php");
}

// Close the database connection
$db->close();
?>
