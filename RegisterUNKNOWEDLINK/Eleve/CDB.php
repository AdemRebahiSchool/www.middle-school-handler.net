<?php
// Database connection
$db = new SQLite3('../../Database/Eleve/User.db');

// Create users table
$query = "
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL,
        FirstName TEXT NOT NULL,
        LastName TEXT NOT NULL,
        password TEXT NOT NULL,
        dob DATE NOT NULL,
        actual_year INTEGER NOT NULL,
        actual_class TEXT NOT NULL,
        profile_picture TEXT
    )
";

$result = $db->exec($query);

if ($result) {
    echo "Table 'users' created successfully!";
} else {
    echo "Error creating table: " . $db->lastErrorMsg();
}

// Close the database connection
$db->close();
?>
