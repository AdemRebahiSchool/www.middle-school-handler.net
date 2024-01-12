<?php
// Ensure there is no whitespace or BOM before this line
session_start();

// Fetch and display user information
$databaseFile = "../../../Database/Proffesseur/User.db";
$db = new SQLite3($databaseFile);

// Assuming the session variable 'username' is set after successful login
$loggedInUsername = $_SESSION['username'];

$query = "SELECT * FROM users WHERE username = '$loggedInUsername'";
$result = $db->querySingle($query, true);

if ($result) {
    $username = $result['username'];
    $firstName = $result['FirstName'];
    $lastName = $result['LastName'];
    $principalTeeacherOf = $result['PrincipalTeacher_Of'];
    $profilePicture = $result['profile_picture'];

    // Display user data as needed
} else {
    // Redirect to the login page if user data cannot be retrieved
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Accueil - <?php echo $username ?></title>
    <link rel="stylesheet" href="dashboard.css">
    <!-- Add your head content here -->
</head>
<header>
    <nav>
        <div class="Link">
            <a href="AddGrade/add.php">Ajoutez une note</a>
        </div>
        <div class="Link">
            <a href="AddHomework/add.php">Ajoutez un devoir</a>
        </div>
        <img id="ImgofProfile" src="/RegisterUNKNOWEDLINK/Proffesseur/uploads/<?php echo $profilePicture ?>" alt="?">
    </nav>
</header>
<body>
    <h2>Dashboard</h2>
    <div>
        <!-- Display current user information -->
        <h3> Bonjour, <?php echo $firstName . ' '. $lastName?></h3>
    </div>
</body>
</html>
