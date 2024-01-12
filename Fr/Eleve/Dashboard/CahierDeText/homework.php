<?php
session_start();

// Get the current logged-in username
$username = $_SESSION['username'];

// Assuming you have a database connection
$userDbPath ="../../../../Database/Eleve/User.db";

try {
    $db = new PDO("sqlite:" . $userDbPath);

    // Set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch the actual_class based on the username
    $query = $db->prepare("SELECT actual_class FROM users WHERE username = :username");
    $query->bindParam(':username', $username);
    $query->execute();

    $userData = $query->fetch(PDO::FETCH_ASSOC);

    if ($userData) {
        // Assign actual_class to the session variable
        $_SESSION['actual_class'] = $userData['actual_class'];
    } else {
        // Handle the case when user data is not found
        echo "User data not found.";
        exit;
    }
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();

    exit;
}

// Now $_SESSION['actual_class'] contains the actual_class for the current user /// 

// Redirect to another section of the same file to display homework
if (isset($_SESSION['actual_class'])) {
    $actualClass = $userData['actual_class'];

    // Assuming you have a database connection for homework
    $homeworkDbPath = "../../../../Database/Classe/{$actualClass}/Homework.db";
    
    try {
        $db = new PDO("sqlite:" . $homeworkDbPath);

        // Set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch homework data for the actual_class
        $homeworkQuery = $db->query("SELECT * FROM homework");
        $homeworkData = $homeworkQuery->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Homework Database Error: " . $e->getMessage();
        echo $actualClass . "";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devoirs à faire - <?php echo $_SESSION['username'];?></title>
    <link rel="shortcut icon" href="/Img/Logo.png">
    <link rel="stylesheet" href="homework.css">
</head>

    <div class="navbar">
        <a href="#"><img src="/Img/Logo.png" alt="Logo"></a>
        <a href="Contenu.php">Contenu Des Cours </a>
        <a href="homework.php">Travail à Faire</a>
        <a href="Fichier.php">Fichier</a>
    </div>

<body>
<br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <h2>Devoirs à faire</h2>
    <?php
    // Display homework data
    foreach ($homeworkData as $homework) {
        $subjectClass = '';

        // Add specific class based on subject
        switch ($homework['subject']) {
            case 'Histoire-Géographie':
                $subjectClass = ' histgeo';
                break;
            case 'Français':
                $subjectClass = ' francais';
                break;
            case 'Mathématiques':
                $subjectClass = ' math';
                break;
            case 'Anglais':
                $subjectClass = ' anglais';
                break;
            case 'Phisyque-Chimie':
                $subjectClass = ' phychi';
                break;
            case 'S.V.T':
                $subjectClass = ' svt';
                break;
            case 'Sport':
                $subjectClass = ' sport';
                break;
            case 'Arts':
                $subjectClass = ' art';
                break;
                case 'Éducation Musicale':
                    $subjectClass = ' Music';
                    break;
            // Add more cases for other subjects as needed
        }

        echo "<div class='homework-item{$subjectClass}'>";
        echo "<h4 class=''>Pour le {$homework['to_date']}</h4>";
        echo "<div class='HeadDiv'>";
        echo "<h3><span class='Color{$subjectClass}'>▢</span>{$homework['subject']}</h3>";
        echo "<h4>{$homework['title']}</h4>";
        echo "</div>";
        echo "<h5>Contenu du cours : {$homework['description']}</h5>";
        echo "<a class='Link' href='https://{$homework['link']}' target='_blank'>Lien supplémentaire : {$homework['link']}</a>";
        

        // Add more details as needed...
        echo "</div>";
        echo '<hr>';
    }
    ?>
</body>
</html>
<?php
} else {
    echo "Actual class not set.";
    exit;
}
?>






