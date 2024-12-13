<?php
session_start();  // Assurer que la session est bien démarrée

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si des catégories sont sélectionnées
    $events = isset($_POST["event"]) ? $_POST["event"] : [];  // Le nom du champ dans le formulaire est "event[]"
    $user_id = $_SESSION['id'];

    if (empty($events)) {
        echo "Aucune préférence sélectionnée.";
        exit();
    }

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "evenement_platform";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Préparer et exécuter la requête pour mettre à jour la préférence de l'utilisateur
    $sql = "UPDATE users SET preference = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Erreur de préparation de la requête UPDATE: " . $conn->error;
        exit();
    }

    // Mettre à jour la préférence
    $preference = 1;  // Assumer que la préférence est 1 (sélectionnée)
    $stmt->bind_param("ii", $preference, $user_id);

    // Vérifier l'exécution de la mise à jour
    if (!$stmt->execute()) {
        echo "Erreur lors de la mise à jour de la préférence de l'utilisateur: " . $stmt->error;
        exit();
    }

    // Fermer la déclaration de mise à jour
    $stmt->close();

    // Préparer la requête d'insertion pour chaque catégorie sélectionnée
    $sql = "INSERT INTO preference_user (user_id, categorie) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Erreur de préparation de la requête INSERT: " . $conn->error;
        exit();
    }

    // Lier les paramètres et insérer chaque préférence dans la base de données
    foreach ($events as $event) {
        $stmt->bind_param("is", $user_id, $event);  // "i" pour INT (user_id), "s" pour STRING (categorie)
        if (!$stmt->execute()) {
            echo "Erreur lors de l'insertion de la préférence pour l'événement '$event': " . $stmt->error;
            exit();
        }
    }

    // Fermer la déclaration d'insertion
    $stmt->close();

    // Fermer la connexion
    $conn->close();

    // Rediriger vers une autre page après avoir ajouté les préférences
    header("Location: bienvenue.php");
    exit();
} else {
    echo "Aucune préférence sélectionnée.";
}
?>
