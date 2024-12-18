<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    // Rediriger vers la page de connexion si non connecté
    header("Location: connexion.php");
    exit();
}

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "pswd";
$dbname = "dz_events";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifier si l'ID de l'événement est passé
if (isset($_POST['event_id']) && isset($_POST['delete_event'])) {
    $event_id = $_POST['event_id'];

    // Requête pour supprimer l'événement
    $sql = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);

    if ($stmt->execute()) {
        // Rediriger vers la page principale après la suppression
        header("Location: mesorganisations.php");
        exit();
    } else {
        echo "Erreur lors de la suppression de l'événement.";
    }
}

$conn->close();
?>
