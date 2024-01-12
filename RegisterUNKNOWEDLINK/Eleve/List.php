<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Data List</title>
</head>
<body>

<div class="container">
    <h1>Data List</h1>

    <div class="data-container">
        <?php
        // Connect to the database
        $db = new SQLite3('../../Database/Eleve/User.db');

        // Assuming the table name is 'users'
        $tableName = 'users';

        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the ID of the item to delete
            $deleteId = $_POST['delete_id'];

            try {
                // Perform the delete operation
                $deleteQuery = "DELETE FROM $tableName WHERE id = :id";
                $stmt = $db->prepare($deleteQuery);
                $stmt->bindValue(':id', $deleteId, SQLITE3_INTEGER);
                $result = $stmt->execute();

                if ($result) {
                    echo "Delete operation executed successfully! Deleted : " . $db->changes() . ' Users';
                } else {
                    echo "No rows were affected by the delete operation.";
                }
            } catch (Exception $e) {
                echo "Error code: " . $e->getCode() . "<br>";
                echo "Error: " . $e->getMessage() . "<br>";
                echo "SQL: " . $deleteQuery;
            }
        }

        // Query to fetch data from the 'users' table
        $query = "SELECT * FROM $tableName";
        $result = $db->query($query);
        
        // Display data
        while ($row = $result->fetchArray()) {
            $LTEST = 'uploads/' . htmlspecialchars($row['profile_pic']) . '';
            $pass = "mayHAk9a7amfu86764";
            echo '<div class="data-item">';
            echo "<div><strong>Nom d'utilisateur:</strong> " . htmlspecialchars($row['username']) . "</div>";
            echo "<div><strong>Prénom:</strong> " . htmlspecialchars($row['FirstName']) . "</div>";
            echo "<div><strong>Nom de Famille:</strong> " . htmlspecialchars($row['LastName']) . "</div>";
            echo '<div><strong>Mot de passe:</strong> ' . str_repeat('*', strlen($row['password'])) . '</div>';
            echo '<div><button class="SeePassButton" onclick="SeePassA(\'' . htmlspecialchars($row['password']) . '\', \'' . $pass . '\')"><ion-icon name="eye-outline"></ion-icon></button></div>';
            echo '<div><strong>Date de naissance:</strong> ' . htmlspecialchars($row['dob']) . '</div>';
            echo "<div><strong>Classe actuelle de l'élève:</strong> " . htmlspecialchars($row['actual_class']) . "</div>";
            echo '<div><strong>Année Scolaire:</strong> ' . htmlspecialchars($row['actual_year']) . '</div>';

            // Modified code to display the profile picture
            $profilePicFileName = htmlspecialchars($row['profile_picture']);
            $profilePicPath = 'uploads/' . $profilePicFileName;
            
            echo '<div><strong>Profile Picture:</strong>';
            if (file_exists($profilePicPath)) {
                echo '<img src="' . $profilePicPath . '" alt="Profile Picture">';
            } else {
                echo ' No profile picture available';
            }
            echo '</div>';

            // Add the delete button here if needed
            echo '<form method="post" action="delete.php">';
            echo '<input type="hidden" name="deleteId" value="' . htmlspecialchars($row['id']) . '">';
            echo '<input type="submit" value="Delete">';
            echo '</form>';

            echo '</div>';
            
        }



        // Close the database connection
        $db->close();
        ?>
        
    </div>
    <script>
            function SeePassA(password, passPr) {
                var promptPass = prompt("Entrez le ");

                if (promptPass === passPr) {
                    var pass = "Accès Accpeté, Voici donc l'information : " + password;
                    alert(pass);
                } else {
                    alert("Accès Réfusé !");
                }
            }
    </script>
</div>



<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>
