<?php
// Connexion à la base de données
try {
    $db = new PDO('sqlite:../../../../Database/Eleve/Grades.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

session_start(); // Assurez-vous d'appeler session_start() au début de votre script

// Vérifiez si l'utilisateur est connecté
if(isset($_SESSION['username'])) {
    $currentUser = $_SESSION['username'];
} else {
    // Redirigez l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: login.php");
    exit();
}

// Requête pour récupérer les notes de l'utilisateur actuel
$userQuery = $db->prepare("SELECT subject, Title, grade, TestDate FROM user_grade WHERE username = :username");
$userQuery->bindParam(':username', $currentUser);
$userQuery->execute();
$userNotes = $userQuery->fetchAll(PDO::FETCH_ASSOC);

// Convertir les notes sur 2 à 19 à une échelle de 0 à 20
foreach ($userNotes as &$note) {
    $originalGrade = $note['grade'];

    // Vérifier si la note originale est numérique
    if (is_numeric($originalGrade)) {
        // Ajuster la note pour qu'elle soit sur 20
        $convertedGrade = round(($originalGrade / 19) * 20, 2);

        // Assurez-vous que la note convertie est limitée à 20
        $note['convertedGrade'] = ($convertedGrade > 20) ? 20 : $convertedGrade;
    } else {
        // Si la note n'est pas numérique, attribuez une valeur par défaut
        $note['convertedGrade'] = 'N/A';
    }
}
unset($note); // Pour éviter des effets inattendus lors de la modification de la dernière valeur
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h1>Notes de l'utilisateur <?php echo $currentUser; ?></h1>

    <h2>Notes personnelles avec conversion</h2>
    <table>
        <tr>
            <th>Matière</th>
            <th>Titre</th>
            <th>Note originale</th>
            <th>Note convertie</th>
            <th>Date du test</th>
        </tr>
        <?php foreach ($userNotes as $note): ?>
            <tr>
                <td><?php echo $note['subject']; ?></td>
                <td><?php echo $note['Title']; ?></td>
                <td><?php echo $note['grade']; ?></td>
                <td><?php echo $note['convertedGrade']; ?></td>
                <td><?php echo $note['TestDate']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Le reste du code pour les notes globales reste inchangé -->
</body>
</html>
