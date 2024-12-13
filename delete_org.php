<?php
// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evenement_platform";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer l'ID de l'événement depuis le formulaire
$id = $_POST['event_id'];

// Requête SQL pour supprimer l'enregistrement avec le event_id donné
$sql = "DELETE FROM events WHERE id = ?";

// Préparer la requête SQL
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id); // "i" signifie un entier (integer)

// Exécuter la requête
if ($stmt->execute()) {
    header("Location: mesorganisations.php");
    exit();
} else {
    echo "Erreur lors de la suppression : " . $stmt->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>
