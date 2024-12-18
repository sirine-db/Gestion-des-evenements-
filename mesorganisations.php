<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    header("Location: connexion.php");
    exit();
}

// Récupérer l'ID de l'utilisateur depuis la session
if (!isset($_SESSION['id'])) {
    die("Erreur : L'ID utilisateur n'est pas défini dans la session.");
}
$user_id = intval($_SESSION['id']); // Assurer que l'ID est un entier

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

// Initialiser la liste des événements
$evenements = [];

// Requête pour récupérer les événements où l'utilisateur est l'organisateur
$sql = "
    SELECT id, name, description, organizer_id, nombre_participant, lieu, date_event, duree, photo_path, status 
    FROM events 
    WHERE organizer_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $evenements[] = $row;
    }
}

// Requête pour récupérer les demandes d'événements où l'utilisateur est l'organisateur
$sql_requests = "
    SELECT er.id AS event_request_id, er.name, er.description, er.organizer_id, 
           er.nombre_participant, er.lieu, er.date_event, er.duree, er.photo_path, er.status
    FROM event_requests er
    WHERE er.organizer_id = ?";

$stmt_requests = $conn->prepare($sql_requests);
$stmt_requests->bind_param("i", $user_id);
$stmt_requests->execute();
$result_requests = $stmt_requests->get_result();

if ($result_requests->num_rows > 0) {
    while ($row = $result_requests->fetch_assoc()) {
        $evenements[] = $row;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Événements</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(120deg, #1a1a1d, #4b134f);
            color: #ffffff;
        }
        header {
            background: rgba(0, 0, 0, 0.8);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            width: 100%;
            padding: 30px 450px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.8);
            display: flex; 
            align-items: center;
            justify-content: space-between;
        }

        /* Navigation (menus) */
        header nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }
        header nav ul .ab{
            position: relative;
            top : 35px; 

        }

        header nav ul li {
            margin: 0 20px;
        }
        header nav ul li img {
            width: 80px; 
            height: 80px;
            border-radius: 50%; 
            object-fit: cover; 
            overflow: hidden; 
        }

        header nav ul li a {
            color: #00f6ff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease-in-out;
        }

        header nav ul li a:hover {
            color: #ff007c;
            text-shadow: 0 0 10px #ff007c;
        }

        header nav ul li a:hover {
            color: #ff007c;
            text-shadow: 0 0 10px #ff007c;
        }
        .event-container {
            padding: 20px;
            margin-top: 100px;
        }
        .event {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            transition: background 0.3s ease;
            justify-content: space-between; 
            align-items: center; 
            position: relative;
        }
        .event:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        .event h3 {
            color: #00f6ff;
            font-size: 1.5rem;
        }
        .event p {
            margin: 5px 0;
        }
        .event .date, .event .location, .event .status {
            color: #ff007c;
        }
        .event .status {
            font-weight: bold;
        }
     

         .delete-btn {
            background-color: #ff0077;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #c7005f;
        } 
        .photos img {
            width: 300px; 
            height: 300px; 
            object-fit: cover;
            border-radius: 8px;
        
        }
    </style>
</head>
<body>
<header>
        <nav>
            <ul>
                <li><a href="bienvenue.php" id="Accueil">Accueil</a></li>
                <li><a href="formulaireorganisation.php" id="Organiser">Organiser un evenement</a></li>
                <li><a href="deconnexion.php" id="deconnect">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <div class="event-container">
        <h2>Mes Événements</h2>
        <?php if (!empty($evenements)): ?>
            <?php foreach ($evenements as $event): ?>
                <div class="event">
                    <h3><?= htmlspecialchars($event['name']); ?></h3>
                    <p class="date">Date: <?= htmlspecialchars($event['date_event']); ?></p>
                    <p class="duration">Durée: <?= htmlspecialchars($event['duree']); ?></p>
                    <p class="location">Lieu: <?= htmlspecialchars($event['lieu']); ?></p>
                    <p class="status">Statut: <?= htmlspecialchars($event['status']); ?></p>
                    <p class="description"><?= htmlspecialchars($event['description']); ?></p>
                    <?php if (!empty($event['photo_path'])): ?>
                        <div class="photos">
                            <img src="<?= htmlspecialchars($event['photo_path']); ?>" alt="Photo de l'événement">
                        </div>
                    <?php endif; ?>

                    <!-- Formulaire de suppression sécurisé -->
                    <form action="delete_org.php" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
                    <input type="hidden" name="event_id" value="<?= isset($event['id']) ? htmlspecialchars($event['id']) : ''; ?>">
                    <button type="submit" name="delete_event" class="delete-btn">Supprimer</button>
                    </form>

                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun événement disponible.</p>
        <?php endif; ?>
    </div>
</body>
</html>