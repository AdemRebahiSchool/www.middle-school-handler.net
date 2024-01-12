<?php
// Ensure there is no whitespace or BOM before this line
session_start();

// ... (rest of your code)

// Inside the form

// Default values for the form
$subject = $title = $link = $to_date = $given_date = $to_who = $description = ''; // Added $to_who and $description

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $subject = $_POST["subject"];
    $teacher = $_POST["teacher"];
    $title = $_POST["title"];
    $link = $_POST["link"];
    $to_date = $_POST["to_date"];
    $given_date = $_POST["given_date"];
    $file_path = ''; // Default value for now
    $file_basicName = $_POST["file"];
    $to_who = $_POST["to_who"];
    $description = $_POST["description"]; // Added

    // Perform validation
    if (empty($subject) || empty($title) || empty($to_date) || empty($to_date) || empty($given_date)) {
        echo "All fields are required.";
        // You might want to redirect or handle the error in a different way
    } else {
        // Handle file upload
        if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
            // Define the directory to store the uploaded files
            $uploadDir = "../../../../Database/Classe/{$to_who}/FichierExterne/";

            // Get the file extension
            $fileExtension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            $fileNameName = $_FILES["file"]["name"];
            $finalNameFile = $fileNameName;

            // Generate a unique filename (e.g., using a combination of timestamp and a random string)
            $filename = time() . '_' . bin2hex(random_bytes(49));

            // Build the full file path with extension
            $file_path = $filename . '.' . $fileExtension;

            // Move the uploaded file to the desired location
            move_uploaded_file($_FILES["file"]["tmp_name"], $uploadDir . $file_path);
        }

        // Assuming you have a database connection
        $dbPath = "../../../../Database/Classe/{$to_who}/Homework.db";
        
        try {
            $db = new PDO("sqlite:" . $dbPath);
            
            // Set the PDO error mode to exception
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Perform database insertion (using a prepared statement)
            $insertQuery = $db->prepare("
                INSERT INTO homework (subject, teacher, title, link, to_date, given_date, file_path, description,file_basicName)
                VALUES (:subject, :teacher, :title, :link, :to_date, :given_date, :file_path, :description,:file_basicName)
            ");

            // Bind parameters
            $insertQuery->bindParam(':subject', $subject);
            $insertQuery->bindParam(':teacher', $teacher);
            $insertQuery->bindParam(':title', $title);
            $insertQuery->bindParam(':link', $link);
            $insertQuery->bindParam(':to_date', $to_date);
            $insertQuery->bindParam(':given_date', $given_date);
            $insertQuery->bindParam(':file_path', $file_path);
            $insertQuery->bindParam(':description', $description);
            $insertQuery->bindParam(':file_basicName', $finalNameFile);
            

            // Execute the query
            $insertQuery->execute();

            echo "Devoir Ajouté !";
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajoutez un devoir - <?php echo $_SESSION['username'];?></title>
    <link rel="stylesheet" href="add.css">
    <link rel="shortcut icon" href="/Img/Logo.png">
</head>
<body>
<div class="container">
    <h2>Formulaire</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <label for="subject">Subject:</label>
        <select name="subject" id="subjectDropdown" required >
            <option value="" disabled selected>Sélectionnez la matière :</option>
            <option value="Français">Français</option>
            <option value="Mathématique">Mathématique</option>
            <option value="Histoire-Géographie">Histoire-Géographie</option>
            <option value="Anglais">Anglais</option>
            <option value="Physique-Chimie">Physique-Chimie</option>
            <option value="Arts">Arts plastique</option>
            <option value="Éducation Musicale">Éducation Musicale</option>
            <option value="ED. Physique&Sport">ED. Physique&Sport</option>
            <option value="S.V.T">Sience de la vie & de la terre</option>
            <option value="Section Sportive Voile">Section Sportive Voile</option>
            
            <!-- Add more options as needed -->
        </select>

        <label for="teacher">Proffesseur:</label>
        <input type="text" name="teacher" value="<?php echo htmlspecialchars($username); ?>" required>

        <label for="title">Titre:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

        <label for="description">Description:</label>
        <textarea name="description"><?php echo htmlspecialchars($description); ?></textarea>

        <label for="link">Lien:</label>
        <input type="text" name="link" value="<?php echo htmlspecialchars($link); ?>">

        <label for="to_date">Pour le:</label>
        <input type="date" name="to_date" value="<?php echo htmlspecialchars($to_date); ?>" required>

        <label for="given_date">Donné le:</label>
        <input type="date" name="given_date" value="<?php echo htmlspecialchars($given_date); ?>" required>
        
        <label for="to_who">Subject:</label>
        <select name="to_who" id="to_whoDropdown" required >
            <option value="" disabled selected>Selectionnez la classe: </option>
            <option value="6A">6A</option>
            <option value="6B">6B</option>
            <option value="6C">6C</option>
            <option value="6D">6D</option>
            <option value="6E">6E</option>
            <option value="5A">5A</option>
            <option value="5B">5B</option>
            <option value="5C">5C</option>
            <option value="5D">5D</option>
            <option value="5E">5E</option>
            <option value="4A">4A</option>
            <option value="4B">4B</option>
            <option value="4C">4C</option>
            <option value="4D">4D</option>
            <option value="4E">4E</option>
            <option value="3A">3A</option>
            <option value="3B">3B</option>
            <option value="3C">3C</option>
            <option value="3D">3D</option>
            <option value="3E">3E</option>
            
            <!-- Add more options as needed -->
        </select>

        <label for="file">Fichier Supplémentaire :</label>
        <input type="file" name="file">

        <input type="submit" value="Envoyer aux élèves">
    </form>

    
    </script>
</div>
</body>
</html>