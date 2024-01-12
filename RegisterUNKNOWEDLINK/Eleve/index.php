<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>User Registration</title>
    <link rel="stylesheet" href="Data/index.css">
</head>
<body>
    <div class="container">
        <form action="register.php" method="post" enctype="multipart/form-data">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>

            <label for="firstName">Prénom:</label>
            <input type="text" id="firstName" name="firstName" required>

            <label for="lastName">Nom de famille:</label>
            <input type="text" id="lastName" name="lastName" required>

            <label for="dob">Date de naissance:</label>
            <input type="date" id="dob" name="dob" required>

            <label for="actual_class">Class Actuelle</label>
            <input type="text" id="actual_class" name="actual_class" required>

            <label for="profilePicture">Photo de profile (.png, .jpeg, .svg, .jpg):</label>
            <input type="file" id="profilePicture" name="profilePicture" accept=".png, .jpeg, .svg, .jpg" required>

            <input type="hidden" name="actual_year" value="<?php echo date('Y'); ?>">

            <button type="submit">Enregistrer</button>
        </form>
    </div>
</body>
</html>
