<?php
// DataList/List.php

$databaseFile = "../../../Database/Proffesseur/User.db";
$db = new SQLite3($databaseFile);

$query = "SELECT * FROM users";
$result = $db->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <style>
        body {
            font-family:monospace;
            display: flex;
            flex-direction: column;
            align-items:center;
            justify-content: center;
        }

        .user-card {
            width: 200px;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .user-image {
            height: 150px;
            width: 50%;
            border-radius: 20%;
            border:2px solid #000;
            overflow: hidden;
            margin: 0 auto 10px;
        }
    </style>
</head>
<body>
    <h2>User List</h2>

    <?php while ($row = $result->fetchArray()): ?>
        <div class="user-card">
            <div class="user-image">
                <img src="../uploads/<?php echo $row['profile_picture']; ?>" alt="?">
            </div>
            <p>Username: <?php echo $row['username']; ?></p>
            <p>Prénom: <?php echo $row['FirstName'] . ', <br>Nom de famille ' . $row['LastName']; ?></p>
            <p> Password : <?php echo $row['password'];?></p>
        </div>
    <?php endwhile; ?>
</body>
</html>
