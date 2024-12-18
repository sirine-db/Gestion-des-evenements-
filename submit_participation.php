<?php
session_start();
// Vérifier si la méthode est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupérer les données du formulaire
    $user_id = $_SESSION['id'];  // ID utilisateur provenant de la session
    $motivation = $_POST['motivation'];
    $participation_status = "en_cours";  // Valeur fixe pour le statut
    $statut = $_POST['statut'];
    $attentes = $_POST['attentes'];
    $rajout = $_POST['rajout'];
    $event_id = $_POST['event_id'];

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "pswd";
    $dbname = "dz_events";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Préparer la requête pour insérer la participation
    $sql = "INSERT INTO event_participation (user_id, motivation, statut, participation_status, attentes, rajout, event_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Préparer la requête avec la base de données
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Erreur de préparation de la requête : " . $conn->error;
        exit();
    }

    $stmt->bind_param("issssss", $user_id, $motivation, $statut, $participation_status, $attentes, $rajout, $event_id);

    // Vérifier si l'exécution est réussie
    if (!$stmt->execute()) {
        echo "Erreur lors de l'insertion de la participation : " . $stmt->error;
        exit();
    }

    // Confirmer l'insertion
    echo "Participation ajoutée avec succès !";

    // Fermer la requête et la connexion
    $stmt->close();
    $conn->close();

    // Rediriger vers une page de confirmation ou autre
    header("Location: http://localhost/tp-web/mesparticipations.php");
    exit();
} 
?>