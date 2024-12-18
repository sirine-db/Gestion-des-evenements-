<?php
// Activer l'affichage des erreurs PHP pour le débogage
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "pswd"; 
$dbname = "dz_events";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier si la connexion est réussie
if ($conn->connect_error) {
    die("Échec de connexion à la base de données : " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées via POST
    $nom = $_POST['nom'] ?? null;
    $nombre_participant = $_POST['nombre_participant'] ?? null;
    $lieu = $_POST['lieu'] ?? null;
    $categorie = $_POST['categorie'] ?? null;
    $date_event = $_POST['date_event'] ?? null;
    $duree = $_POST['duree'] ?? null;
    $description = $_POST['description'] ?? null;
    $photo_path = $_POST['photo_path'] ?? null;

    // Simuler un utilisateur connecté avec un ID (remplacez ceci par une gestion réelle des sessions)
    session_start();
    $organizer_id = $_SESSION['id'] ?? null; // ID de l'organisateur connecté

    // Valider que tous les champs obligatoires sont remplis
    if (!$nom || !$nombre_participant || !$lieu || !$categorie || !$date_event || !$duree || !$description || !$photo_path || !$organizer_id) {
        die("Tous les champs sont obligatoires.");
    }

    // Liste des catégories valides (correspond à l'ENUM dans la base)
    $categories_valides = [
        'Musique', 'Atelier', 'Séminaire', 'professionnels', 'culturels',
        'sociaux', 'sportifs', 'éducatifs', 'caritatifs', 'religieux',
        'loisirs', 'technologiques', 'virtuels'
    ];

    // Vérifier que la catégorie est valide
    if (!in_array($categorie, $categories_valides)) {
        die("Catégorie invalide !");
    }

    // Préparer la requête SQL avec des données sécurisées
    $stmt = $conn->prepare("INSERT INTO event_requests 
        (name, nombre_participant, lieu, categorie, date_event, duree, description, photo_path, organizer_id, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    
    if (!$stmt) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmt->bind_param(
        "sissssssi",
        $nom, $nombre_participant, $lieu, $categorie, $date_event, $duree, $description, $photo_path, $organizer_id
    );

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "<p>Demande d'organisation soumise avec succès. Vous serez redirigé vers la page d'accueil.</p>";
        header("refresh:3;url=bienvenue.php"); // Redirection après 3 secondes
        exit();
    } else {
        echo "Erreur lors de la soumission : " . $stmt->error;
    }

    // Fermer la requête préparée
    $stmt->close();
}

// Fermer la connexion à la base de données
$conn->close();
?>

<!-- Formulaire d'envoi de demande d'organisation -->
<form method="POST">
    <label for="nom">Nom de l'événement :</label><br>
    <input type="text" id="nom" name="nom" required><br><br>

    <label for="nombre_participant">Nombre de participants :</label><br>
    <input type="number" id="nombre_participant" name="nombre_participant" required><br><br>

    <label for="lieu">Lieu :</label><br>
    <input type="text" id="lieu" name="lieu" required><br><br>

    <label for="categorie">Catégorie :</label><br>
    <select id="categorie" name="categorie" required>
        <option value="" disabled selected>-- Choisir une catégorie --</option>
        <option value="Musique">Musique</option>
        <option value="Atelier">Atelier</option>
        <option value="Séminaire">Séminaire</option>
        <option value="professionnels">Professionnels</option>
        <option value="culturels">Culturels</option>
        <option value="sociaux">Sociaux</option>
        <option value="sportifs">Sportifs</option>
        <option value="éducatifs">Éducatifs</option>
        <option value="caritatifs">Caritatifs</option>
        <option value="religieux">Religieux</option>
        <option value="loisirs">Loisirs</option>
        <option value="technologiques">Technologiques</option>
        <option value="virtuels">Virtuels</option>
    </select><br><br>

    <label for="date_event">Date de l'événement :</label><br>
    <input type="date" id="date_event" name="date_event" required><br><br>

    <label for="duree">Durée :</label><br>
    <input type="time" id="duree" name="duree" required><br><br>

    <label for="description">Description :</label><br>
    <textarea id="description" name="description" required></textarea><br><br>

    <label for="photo_path">Photo de l'événement (URL) :</label><br>
    <input type="text" id="photo_path" name="photo_path" required><br><br>

    <input type="submit" value="Organiser l'événement">
</form>
