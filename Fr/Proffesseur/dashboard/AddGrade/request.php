<?php
// AddGrade/add.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $firstName = $_POST["FirstName"];
    $lastName = $_POST["LastName"];
    $subject = $_POST["subject"];
    $titre = $_POST["Title"];
    $grade = $_POST["grade"];
    $trimester = $_POST["trimester"];
    $testDate = $_POST["testDate"];
    

    // Save grade data to the database
    $databaseFile = "../../../../Database/Eleve/Grades.db";
    $db = new SQLite3($databaseFile);

    $query = "INSERT INTO user_grade (username, FirstName, LastName, subject, Title, grade, trimester, testDate) VALUES ('$username', '$firstName', '$lastName', '$subject', '$titre', '$grade', '$trimester', '$testDate')";
    $db->exec($query);

    header('Location: ../dashboard.php');
}

$loggedInUsername = $_SESSION['username'];
?>