<?php
// register.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $password = $_POST["password"];
    $dob = $_POST["dob"];
    $principalTeacherOf = $_POST["principalTeacherOf"];

    // Save profile picture
    $file_name = $_FILES["profilePicture"]["name"];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $new_file_name = uniqid('', true) . '.' . $file_ext;
    move_uploaded_file($_FILES["profilePicture"]["tmp_name"], "uploads/" . $new_file_name);

    // Save user data to the database
    $databaseFile = "../../Database/Proffesseur/User.db";
    $db = new SQLite3($databaseFile);
    
    $query = "INSERT INTO users (username, firstName, lastName, password, dob, principalTeacher_Of, profile_picture) VALUES ('$username', '$firstName', '$lastName', '$password', '$dob', '$principalTeacherOf', '$new_file_name')";
    $db->exec($query);

    // Redirect to user list page
    header("Location: DataList/List.php");
    exit();
}
?>
