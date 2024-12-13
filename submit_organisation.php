<?php
session_start();

// Vérifier si la méthode est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupérer les données du formulaire
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $description = isset($_POST['Description']) ? $_POST['Description'] : '';
    $lieu = isset($_POST['lieu']) ? $_POST['lieu'] : '';
    $ville = isset($_POST['ville']) ? $_POST['ville'] : '';
    $categorie = isset($_POST['categorie']) ? $_POST['categorie'] : '';
    $datedeb = isset($_POST['datedeb']) ? $_POST['datedeb'] : '';
    $datefin = isset($_POST['datefin']) ? $_POST['datefin'] : '';
    $heure = isset($_POST['heure']) ? $_POST['heure'] : '';
    $heurefin = isset($_POST['heurefin']) ? $_POST['heurefin'] : '';

    $photo1 = isset($_POST['photo1']) ? $_POST['photo1'] : '';
    $photo2 = isset($_POST['photo2']) ? $_POST['photo2'] : '';
    $photo3 = isset($_POST['photo3']) ? $_POST['photo3'] : '';

    // Récupérer l'ID de l'organisateur depuis la session
    $organizer_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

    // Informations de connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "evenement_platform";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    // Insérer un événement avec un statut par défaut 'pending'
    $sql = "INSERT INTO events (description, lieu, ville, categorie, date_debut, date_fin, heure_debut, heure_fin, organizer_id, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
    
    // Préparer la requête avec la base de données
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Erreur de préparation de la requête : " . $conn->error;
        exit();
    }

    // Lier les paramètres
    $stmt->bind_param("ssssssssi", $description, $lieu, $ville, $categorie, $datedeb, $datefin, $heure, $heurefin, $organizer_id);

    // Exécuter la requête
    if (!$stmt->execute()) {
        echo "Erreur lors de l'insertion de l'événement : " . $stmt->error;
        exit();
    }

    // Récupérer l'ID de l'événement nouvellement inséré
    $eventid = $conn->insert_id;

    // Insertion des photos
    $sql = "INSERT INTO event_photos (photo_url, event_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Erreur de préparation de la requête : " . $conn->error;
        exit();
    }

    // Lier et exécuter les requêtes pour chaque photo
    if ($photo1) {
        $stmt->bind_param("si", $photo1, $eventid);
        if (!$stmt->execute()) {
            echo "Erreur lors de l'insertion de la photo 1 : " . $stmt->error;
            exit();
        }
    }

    if ($photo2) {
        $stmt->bind_param("si", $photo2, $eventid);
        if (!$stmt->execute()) {
            echo "Erreur lors de l'insertion de la photo 2 : " . $stmt->error;
            exit();
        }
    }

    if ($photo3) {
        $stmt->bind_param("si", $photo3, $eventid);
        if (!$stmt->execute()) {
            echo "Erreur lors de l'insertion de la photo 3 : " . $stmt->error;
            exit();
        }
    }

    // Fermer la requête et la connexion
    $stmt->close();
    $conn->close();

    // Rediriger vers une page de confirmation ou autre
    header("Location: http://localhost/tpweb/mesorganisations.php");
    exit();
}

?>
