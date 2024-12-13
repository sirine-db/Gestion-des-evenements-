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
        "nbr_participants_actuels" => $_GET['nbr_participants_actuels'],  // Nombre de participants actuels
        "lieu" => $_GET['lieu'],  // Lieu de l'événement
        "ville" => $_GET['ville'],  // Ville de l'événement
        "date_debut" => $_GET['date_debut'],  // Date de début
        "date_fin" => $_GET['date_fin'],  // Date de fin
        "heure_debut" => $_GET['heure_debut'],  // Heure de début
        "heure_fin" => $_GET['heure_fin'],  // Heure de fin
        "categorie" => $_GET['categorie'],  // Catégorie de l'événement
        "photos" => $_GET['photos'],  // Catégorie de l'événement
 
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



            <label for="statutsocial">statutsocial :</label>
            <select id="statutsocial" name="statutsocial" required>
                <option value="">-- Sélectionnez votre statutsocial --</option>
                <option value="etudiant">étudiant</option>
                <option value="professionnelle">professionnelle</option>
                <option value="retraité">retraité</option>
                <option value="autre">autre</option>
                
            </select>

          
            <label for="rajout">rajouter quelque chose :</label>
            <textarea id="rajout" name="rajout" placeholder="qlq chose que vous voulez specifier de plus" rows="2" required></textarea>

    
        <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">

            <button type="submit">Reserver ma place</button>
        </form>
    </div>







    <div class="event-container">
        
        <div class="event-details">
            <div class="event-photo-container">
            <img src="<?php echo $event['photos']; ?> " alt="">
            </div>
           
            <p><strong>Description:</strong> <?php echo $event['description']; ?></p>
            <p><strong>Lieu:</strong> <?php echo $event['lieu']; ?>, <?php echo $event['ville']; ?></p>
            <p><strong>Date:</strong> <?php echo $event['date_debut']; ?> - <?php echo $event['date_fin']; ?></p>
            <p><strong>Heure:</strong> <?php echo $event['heure_debut']; ?> - <?php echo $event['heure_fin']; ?></p>
            <p><strong>Participants:</strong> <?php echo $event['nbr_participants_actuels']; ?></p>
            <p><strong>Catégorie:</strong> <?php echo $event['categorie']; ?></p>

        </div>
    </div>
</body>
</html>
