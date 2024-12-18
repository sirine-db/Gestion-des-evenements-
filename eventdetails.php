<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    // Rediriger vers la page de connexion si non connecté
    header("Location: login.php");
    exit();
}

// Vérifier si la méthode de la requête est GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Récupérer les données envoyées via GET
    $event = [
        "id" => $_GET['id'],  // ID de l'événement
        "nom" => $_GET['nom'],  // Nom de l'événement
        "description" => $_GET['description'],  // Description de l'événement
        "organisateur_id" => $_GET['organisateur_id'],  // ID de l'organisateur
        "rating" => $_GET['rating'],  // Note de l'événement
        "nbr_participants_actuels" => $_GET['nbr_participants_actuels'],  // Nombre de participants actuels
        "lieu" => $_GET['lieu'],  // Lieu de l'événement
        "ville" => $_GET['ville'],  // Ville de l'événement
        "adresse" => $_GET['adresse'],  // Adresse GPS de l'événement
        "date_debut" => $_GET['date_debut'],  // Date de début
        "date_fin" => $_GET['date_fin'],  // Date de fin
        "heure_debut" => $_GET['heure_debut'],  // Heure de début
        "heure_fin" => $_GET['heure_fin'],  // Heure de fin
        "categorie" => $_GET['categorie'],  // Catégorie de l'événement
        "photos" => $_GET['photo1']  // URL de la première photo // c la photo principale
        
    ];
} else {
    header("Location: bienvenue.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Participation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(120deg, #1a1a1d, #4b134f);
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            display: flex;
            justify-content: flex-end; 
            align-items: center; 
        
        }
        .event-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px 20px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 500px;
            box-sizing: border-box;
            position: absolute;
            left:70px;
        }
        .event-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .event-header h1 {
            color: white;
    
        }
        .event-photo-container img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .event-details {
            margin-top: 20px;
            color: white;
        }
        .event-details p {
            margin-bottom: 10px;
        }
        .rating {
            font-size: 1.2rem;
            color: #ffcc00;
        }
    </style>
</head>
<body>

    <div class="event-container">
        <div class="event-header">
            <h1><?php echo $event['nom']; ?></h1>
            <div class="event-photo-container">
        
                    <img src="<?php echo $photo; ?>" alt="Photo de l'événement">
              
            </div>
        </div>
        
        <div class="event-details">
            <p><strong>Description:</strong> <?php echo $event['description']; ?></p>
            <p><strong>Lieu:</strong> <?php echo $event['lieu']; ?>, <?php echo $event['ville']; ?></p>
            <p><strong>Date:</strong> <?php echo $event['date_debut']; ?> - <?php echo $event['date_fin']; ?></p>
            <p><strong>Heure:</strong> <?php echo $event['heure_debut']; ?> - <?php echo $event['heure_fin']; ?></p>
            <p><strong>Participants:</strong> <?php echo $event['nbr_participants_actuels']; ?></p>
            <p><strong>Catégorie:</strong> <?php echo $event['categorie']; ?></p>
            <p class="rating"><strong>Évaluation:</strong> <?php echo number_format($event['rating'], 1); ?> / 5</p>
            <p><strong>Adresse:</strong> <?php echo $event['adresse']; ?></p>
        </div>
    </div>
</body>
</html>
