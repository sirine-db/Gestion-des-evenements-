<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    // Redirection vers la page de connexion si non connecté
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

// Vérifier si l'ID utilisateur est disponible
if (!isset($_SESSION['user_id'])) {
    die("Erreur : L'ID utilisateur n'est pas défini dans la session.");
}

// Récupérer l'ID utilisateur depuis la session
$user_id = $_SESSION['user_id'];

// Préparer la requête pour récupérer les participations de l'utilisateur
$sql = "
    SELECT ep.event_id, ep.user_id, ep.participation_status, 
           e.name AS event_name, e.description AS event_description
    FROM event_participation ep
    JOIN events e ON ep.event_id = e.id
    WHERE ep.user_id = ?"; // Utilisation d'un paramètre pour éviter les injections SQL

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // Associer l'ID utilisateur au paramètre
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Participations</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(120deg, #1a1a1d, #4b134f);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        header {
            background: rgba(0, 0, 0, 0.8);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            width: 100%;
            padding: 30px 20px; /* Adjusted for responsiveness */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        /* Other styles remain unchanged */
        .event-container {
            position: absolute;
            top: 100px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px 20px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
            width: 80%;
            max-width: 800px;
            margin-top: 100px;
            box-sizing: border-box;
        }
        /* Additional styles for events */
        .event {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            transition: background 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="event-container">
        <h2>Liste de mes participations</h2>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="event">
                    <h3>Événement : <?= htmlspecialchars($row['event_name']) ?></h3>
                    <p>Description : <?= htmlspecialchars($row['event_description']) ?></p>
                    <p>État de la participation : <strong><?= htmlspecialchars($row['participation_status']) ?></strong></p>
                    <form action="delete_event.php" method="POST" style="display:inline;">
                        <input type="hidden" name="event_id" value="<?= $row['event_id'] ?>">
                        <button type="submit" class="delete-btn">Supprimer</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Aucune participation trouvée.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Fermer la connexion à la base de données
$stmt->close();
$conn->close();
?>