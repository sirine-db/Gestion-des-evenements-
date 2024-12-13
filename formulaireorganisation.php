<?php

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion si non connecté
    header("Location: login.php");
    exit();
}

$categories = [
    "Musique",
    "Atelier",
    "Séminaire",
    "professionnels",
    "culturels",
    "sociaux",
    "sportifs", 
    "éducatifs", 
    "caritatifs",
    "religieux",
    "loisirs",
    "technologiques", 
    "virtuels",
];

// Villes des événements
$villes = [
    "Alger",
    "Oran",
    "Constantine",
    "Annaba"
];

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d"organisation</title>
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
    min-height: 100vh; /* Assure que l'élément occupe toute la hauteur de la fenêtre */
}

.form-container {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    padding: 30px 20px;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
    width: 100%;
    max-width: 400px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column; /* Permet de centrer les éléments du formulaire verticalement */
    align-items: center; /* Centre les éléments horizontalement */
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









    </style>
    
</head>
<body>
    <div class="form-container">
        <h2>Demande organiseation evenement</h2>
        <div class="event-container">
     
        <form action="http://localhost/tpweb/submit_organisation.php" method="POST">


            <label for="nom">nom :</label>
            <input id="nom" name="nom" placeholder="nom evenement " required>
            
            

            <label for="Description">Description :</label>
            <textarea id="Description" name="Description" placeholder="descrivez brievement votre evenement " rows="3" required></textarea>
            

            
            <label for="lieu">lieu :</label>
            <input type="lieu" id="lieu" name="lieu" placeholder="7 rue saadi abderrahmane" required>
            <label for="ville">Ville :</label>
    <select id="ville" name="ville" required>
        <option value="">-- Sélectionnez une ville --</option>
        <?php foreach ($villes as $ville): ?>
            <option value="<?= htmlspecialchars($ville) ?>"><?= htmlspecialchars($ville) ?></option>
        <?php endforeach; ?>
    </select>

    <!-- Champ Catégorie -->
    <label for="categorie">Catégorie :</label>
    <select id="categorie" name="categorie" required>
        <option value="">-- Sélectionnez la catégorie --</option>
        <?php foreach ($categories as $categorie): ?>
            <option value="<?= htmlspecialchars($categorie) ?>"><?= htmlspecialchars($categorie) ?></option>
        <?php endforeach; ?>
    </select>


            <label for="datedeb">date debut de votre evenement :</label>
            <input type="date" id="datedeb" name="datedeb"  required>
            <label for="datefin">date fin de votre evenement :</label>
            <input type="date" id="datefin" name="datefin"  required>
            <label for="heure">Sélectionnez une heure :</label>
            <input type="time" id="heure" name="heure"required>
            <label for="heurefin">Sélectionnez une heure :</label>
            <input type="time" id="heurefin" name="heurefin"required>

            <label for="photo1">entrez l url de la photo 1(obligatoire)</label>
            <input type="input" id="photo1" name="photo1"required>
            <label for="photo2">entrez l url de la photo 2(optionnel)</label>
            <input type="input" id="photo2" name="photo2">
            <label for="photo3">entrez l url de la photo 3(optionnel)</label>
            <input type="input" id="photo3" name="photo3" >

            <button type="submit">organiser</button>
        </form>
    </div>








    </div>
</body>
</html>
