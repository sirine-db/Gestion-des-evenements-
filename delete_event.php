<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$host = "localhost";
$user = "root";
$password = "pswd";
$dbname = "dz_events";

$conn = new mysqli($host, $user, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérifier si l'ID de l'événement est reçu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event_id = intval($_POST['event_id']); // Convertir en entier pour éviter les injections SQL
    
    // Préparer la requête de suppression
    $sql = "DELETE FROM event_participation WHERE event_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $event_id, // Vérifier la connexion
);
    
    if ($stmt->execute()) {
        // Rediriger vers la page des participations avec un message de succès
        header("Location: mesparticipations.php?status=success");
    } else {
        // Rediriger avec un message d'erreur
        header("Location: participations.php?status=error");
    }

    $stmt->close();
} else {
    // Rediriger avec un message d'erreur
    header("Location: participations.php?status=invalid");
}

$conn->close();
?>
