<?php
// login.php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate user credentials (Check against the database)
    $databaseFile = "../../Database/Proffesseur/User.db";
    $db = new SQLite3($databaseFile);

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $db->querySingle($query, true);

    if ($result) {
        $_SESSION['username'] = $result['username'];
        $_SESSION['firstName'] = $result['FirstName'];
        $_SESSION['lastName'] = $result['LastName'];
        // Redirect to the dashboard upon successful login
        header("Location: dashboard/dashboard.php");
        exit();
    } else {
        echo "Mot de passe ou nom d'utilisateur incorrecte";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add your head content here -->
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="post">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
