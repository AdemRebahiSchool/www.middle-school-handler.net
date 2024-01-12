<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in, if not redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Get the user information from the session
$username = $_SESSION['username'];

// Fetch additional information from the database
$databasePath = "../../../Database/Eleve/User.db";
$db = new SQLite3($databasePath);
$query = $db->prepare("SELECT * FROM users WHERE username = :username");
$query->bindValue(':username', $username, SQLITE3_TEXT);
$result = $query->execute();
$userData = $result->fetchArray();

// Close the database connection
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - <?php echo $_SESSION['username']; ?></title>
    <link rel="shortcut icon" href="/Img/Logo.png">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <a href="#"><img src="../../../Img/Logo.png" alt="Logo"></a>
        <a href="Notes/index.php">Notes</a>
        <a href="#">Communication</a>
        <a href="#">Vie Scolaire</a>
        <a href="#">Compétences</a>
        <a href="CahierDeText/homework.php">Cahier de texte</a>
        <a href="UserInfo/profile.php" class="profile-link">
            <div class="profile-icon">
                <?php
                // Display the user profile picture
                $profilePicture = $userData['profile_picture'];
                if ($profilePicture) {
                    echo '<img src="../../../RegisterUNKNOWEDLINK/Eleve/uploads/' . $profilePicture . '" alt="Profile Picture">';
                } else {
                    echo 'Profile';
                }
                ?>
            </div>
        </a>
    
    </div>

    <!-- Dashboard content -->
    <div class="dashboard-container">
        <h2>Bonjour, <?php echo $username; ?>!</h2>
        <div>
            <p><strong>Nom d'utilisateur:</strong> <?php echo $userData['username']; ?></p>
            <p><strong>Date de naissance:</strong> <?php echo $userData['dob']; ?></p>
        </div>
        
        <!-- Additional dashboard content goes here -->
    </div>
    <div class="Homework">
        <?php include 'LinkToHomework.php'; ?>
        <?php include 'filewiddgethomewwork.php'; ?>
    </div>

    
</body>
</html>

