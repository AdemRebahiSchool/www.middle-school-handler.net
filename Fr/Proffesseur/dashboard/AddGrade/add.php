<?php

session_start();

$loggedInUsername = $_SESSION['username'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Grades - <?php echo $loggedInUsername?></title>
    <link rel="stylesheet" href="add.css">
</head>
<title>Ajoutez une note - <?php echo $_SESSION['username']; ?></title>
<body>
    <h2>Ajoutez une note</h2>
    <form action="request.php" method="post">
        À (Nom d'utilisateur de l'élève): <input type="text" name="username" required><br>
        Prénom: <input type="text" name="FirstName" required><br>
        Nom de famille: <input type="text" name="LastName" required><br>
        Matière : <input type="text" name="subject" required><br>
        Titre: <input type="text" name="Title" required><br>
        Note: <input type="text" name="grade" required><br>
        Trimestre (1,2,3):<input type="text" name="trimester" required><br>
        Date du contôle: <input type="date" name="testDate" required><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
