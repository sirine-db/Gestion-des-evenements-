<?php

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    // Rediriger vers la page de connexion si non connecté
    header("Location: login.php");
    exit();

}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simuler l'obtention des données via POST (c'est normalement à partir d'un formulaire)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les données envoyées via POST
        $event = [
            "id" => $_POST['id'],  // ID de l'événement
            "nom" => $_POST['nom'],  // Nom de l'événement
            "description" => $_POST['description'],  // Description de l'événement
            "organisateur_id" => $_POST['organisateur_id'],  // ID de l'organisateur
            "rating" => $_POST['rating'],  // Note de l'événement
            "nbr_participants_actuels" => $_POST['nbr_participants_actuels'],  // Nombre de participants actuels
            "lieu" => $_POST['lieu'],  // Lieu de l'événement
            "ville" => $_POST['ville'],  // Ville de l'événement
            "adresse" => $_POST['adresse'],  // Adresse GPS de l'événement
            "date_debut" => $_POST['date_debut'],  // Date de début
            "date_fin" => $_POST['date_fin'],  // Date de fin
            "heure_debut" => $_POST['heure_debut'],  // Heure de début
            "heure_fin" => $_POST['heure_fin'],  // Heure de fin
            "categorie" => $_POST['categorie'],  // Catégorie de l'événement
            "photos" => [
                $_POST['photo1']// URL de la première photo // c la photo principale
            ]
        ];
    } else {
        header("Location: bienvenue.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Participation</title>
    <style>
        /* Reprise du thème global */
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
    justify-content: flex-end; /* Aligne à droite */
    align-items: center; /* Centre verticalement */
        
        }

        .form-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px 20px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 500px;
            box-sizing: border-box;
            position: relative;
            right:70px;
        }

        .form-container h2 {
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 15px;
            background: linear-gradient(90deg, #ff0077, #00f6ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-container label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        .form-container input,
        .form-container textarea,
        .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.2);

            font-size: 1rem;
            box-sizing: border-box;
            transition: border-color 0.3s ease, background 0.3s ease;
        }

        .form-container input:focus,
        .form-container textarea:focus,
        .form-container select:focus {
            border-color: #00f6ff;
            background: rgba(255, 255, 255, 0.3);
            outline: none;
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(90deg, #ff0077, #00f6ff);
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .form-container button:hover {
            background: linear-gradient(90deg, #c7005f, #008fbf);
            transform: translateY(-3px);
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
    <div class="form-container">
        <h2>Formulaire de Participation</h2>
        <form action="http://localhost/tpweb/submit_participation.php" method="POST">
            <label for="name" >Nom complet :</label>
            <input type="text" id="name" name="name" placeholder="Votre nom" value="<?php echo $_SESSION['nom'].' '.$_SESSION['prenom'];?>" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" placeholder="exemple@mail.com" value="<?php echo $_SESSION['email']?>" required>

            <label for="phone" >Numéro de téléphone :</label>
            <input type="text" id="phone" name="phone" value=<?php echo $_SESSION['num']?> >


            <label for="motivation">Motivation :</label>
            <textarea id="motivation" name="motivation" placeholder="Expliquez pourquoi vous souhaitez participer" rows="4" required></textarea>


            
            <label for="attentes">vos attentes :</label>
            <textarea id="attentes" name="attentes" placeholder="Expliquez brievement vos attente de cette event" rows="3" required></textarea>



            <label for="statut">statut :</label>
            <select id="statut" name="statut" required>
                <option value="">-- Sélectionnez votre statut --</option>
                <option value="etudiant">étudiant</option>
                <option value="professionnelle">professionnelle</option>
                <option value="retraité">retraité</option>
                <option value="autre">autre</option>
                
            </select>

          
            <label for="rajout">rajouter quelque chose :</label>
            <textarea id="rajout" name="rajout" placeholder="qlq chose que vous voulez specifier de plus" rows="2" required></textarea>



            <button type="submit">Reserver ma place</button>
        </form>
    </div>







    <div class="event-container">
        <div class="event-header">
            <h1><?php echo $event['nom']; ?></h1>
            <div class="event-photo-container">
                <?php foreach ($event['photos'] as $photo): ?>
                    <img src="<?php echo $photo; ?>" alt="Photo de l'événement">
                <?php endforeach; ?>
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
