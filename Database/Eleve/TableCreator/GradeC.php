<?php 

$db = new SQLite3('../Grades.db');
$query = "
    CREATE TABLE IF NOT EXISTS user_grade (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL,
        FirstName TEXT NOT NULL,
        LastName TEXT NOT NULL,
        subject TEXT NOT NULL,
        Title TEXT NOT NULL,
        grade NUMERIC NOT NULL,
        trimester TEXT NOT NULL,
        TestDate DATE NOT NULL
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

