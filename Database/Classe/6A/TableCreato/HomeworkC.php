<?php
// Database connection
$db = new SQLite3('../Homework.db');

// Create users table
$query = "
    CREATE TABLE IF NOT EXISTS homework (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        subject TEXT NOT NULL,
        teacher TEXT NOT NULL,
        title TEXT NOT NULL,
        description TEXT NOT NULL,
        link TEXT NOT NULL,
        to_date DATE NOT NULL,
        given_date DATE NOT NULL,
        file_path TEXT,
        file_basicName TEXT

    )
";

$result = $db->exec($query);

if ($result) {
    echo "Table 'homework' created successfully!";
} else {
    echo "Error creating table: " . $db->lastErrorMsg();
}

// Close the database connection
$db->close();
?>
