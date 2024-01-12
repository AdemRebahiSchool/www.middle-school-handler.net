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
$databasePath = "../../../../Database/Eleve/User.db";
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
    <title>Informations & Données - <?php echo $_SESSION['username']; ?></title>
    <link rel="shortcut icon" href="/Img/Logo.png">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f5f5f5;
            text-align: center;
            padding: 50px;
        }

        .profile-container {
            max-width: 400px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-container div {
            margin-bottom: 15px;
        }

        .profile-container h2 {
            color: #333;
        }

        .profile-container p {
            color: #777;
        }

        .profile-container img {
            border:2px solid #000;
            width:100%;
            border-radius:15px;
        }
    </style>
</head>
<body>
    <!-- Profile content -->
    <div class="profile-container">
        <h2>Informations sur le compte- <?php echo $username; ?></h2>
        <div>
            <?php $pass = "mayHAk9a7amfu86764";?>
            <p><strong>Nom d'utilisateur:</strong> <?php echo $userData['username']; ?></p>
            <p><strong>Prénom:</strong> <?php echo $userData['FirstName']; ?></p>
            <p><strong>Nom de famille:</strong> <?php echo $userData['LastName']; ?></p>
            <p><strong>Mot de passe:</strong> <?php echo str_repeat('*', strlen($userData['password'])); ?></p>
            <button class="SeePassButton" onclick="SeePass()"><ion-icon name="eye-outline"></ion-icon></button>
            <p><strong>Date of Birth:</strong> <?php echo $userData['dob']; ?></p>
            <p><strong>Actual year:</strong> <?php echo $userData['actual_year']; ?></p>
            <img src="<?php echo '../../../../RegisterUNKNOWEDLINK/Eleve/uploads/' . $userData['profile_picture'] ?>"  >
            <!-- Add any other user information you want to display -->
        </div>
    </div>



</body>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script>
    document.getElementById('SeePassButton').addEventListener('click', function() {
    
})
</script>

</html>
