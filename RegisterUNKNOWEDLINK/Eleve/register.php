<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Store the plain text password
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dob = $_POST['dob']; 
    $actual_year = $_POST['actual_year'];
    $actual_class = $_POST['actual_class'];
    // Check if a file was uploaded
    if (isset($_FILES['profilePicture'])) {
        $file = $_FILES['profilePicture'];
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_error = $file['error'];

        // Get the file extension
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Allowed file extensions
        $allowed_extensions = array('png', 'jpeg', 'svg', 'jpg');

        if (in_array($file_ext, $allowed_extensions)) {
            // Unique filename to avoid overwriting existing files
            $new_file_name = uniqid('', true) . '.' . $file_ext;

            // Move the uploaded file to a specified directory
            move_uploaded_file($file_tmp, 'uploads/' . $new_file_name);

            // Database connection and insertion (using SQLite in this example)
            $db = new SQLite3('../../Database/Eleve/User.db');

            // Begin a transaction
            $db->exec('BEGIN TRANSACTION');

            // Database insertion with error handling
            $query = "INSERT INTO users (username, password, firstName, lastName, dob, actual_year, actual_class, profile_picture) 
                      VALUES ('$username', '$password', '$firstName', '$lastName', '$dob', '$actual_year', '$actual_class', '$new_file_name')";
            $result = $db->exec($query);

            // Commit the transaction
            $db->exec('COMMIT');

            // Check for errors during the database insertion
            if ($result) {
                header('Location: List.php');
                exit();
            } else {
                echo "Error in registration. Details: " . $db->lastErrorMsg();
            }
            
            // Close the database connection
            $db->close();
        } else {
            echo "Invalid file extension. Allowed extensions are .png, .jpeg, .svg.";
        }
    } else {
        echo "No file uploaded.";
    }
}
?>
