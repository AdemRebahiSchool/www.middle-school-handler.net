<?php
// Database connection
$db = new SQLite3('../Controle.db');

// Create users table
$query = "
    CREATE TABLE IF NOT EXISTS controle (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        ClassAverage NUMERIC NOT NULL,
        HighestAverage NUMERIC NOT NULL,
        LowestAverage NUMERIC NOT NULL,
        Title TEXT NOT NULL,
        dateOfTest DATE NOT NULL
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
