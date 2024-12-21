<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: connexion.php");
    exit();
}

// Vérifier si l'ID de l'événement est passé
if (isset($_POST['event_id']) && isset($_POST['delete_event'])) {
    $event_id = $_POST['event_id'];

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "pswd";
    $dbname = "dz_events";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Erreur de connexion : " . $conn->connect_error);
    }

    // Commencer une transaction
    $conn->begin_transaction();

    try {
        // Supprimer l'événement de la table event_participants
        $sql = "DELETE FROM event_participation WHERE event_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $stmt->close();

        // Supprimer l'événement de la table event_requests
        $sql = "DELETE FROM event_requests WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $stmt->close();

        // Supprimer l'événement de la table events
        $sql = "DELETE FROM events WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $stmt->close();

        // Commit de la transaction
        $conn->commit();

        // Rediriger vers la page des événements après suppression
        header("Location: mesorganisations.php");
        exit();
    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        $conn->rollback();
        echo "Erreur lors de la suppression de l'événement : " . $e->getMessage();
    }

    $conn->close();
} else {
    echo "ID de l'événement manquant.";
}
?>
