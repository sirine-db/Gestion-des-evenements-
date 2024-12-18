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
    "Annaba",
    "Setif",
    "Djijel"
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'organisation</title>
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
        min-height: 100vh; 
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
        flex-direction: column;
        align-items: center; 
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
        <h2>Demande d'organisation d'événement</h2>
        <form action="http://localhost/tp-web/submit_organisation.php" method="POST">
            <label for="nom">Nom de l'événement :</label>
            <input id="nom" name="nom" placeholder="Nom de l'événement" required>

            <label for="nombre_participant">Nombre de participants :</label>
            <input id="nombre_participant" name="nombre_participant" type="number" placeholder="Nombre de participants" required>

            <label for="lieu">Lieu :</label>
            <select id="lieu" name="lieu" required>
                <option value="">-- Sélectionnez un lieu --</option>
                <?php foreach ($villes as $ville): ?>
                    <option value="<?= htmlspecialchars($ville) ?>"><?= htmlspecialchars($ville) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="categorie">Catégorie :</label>
            <select id="categorie" name="categorie" required>
                <option value="">-- Sélectionnez la catégorie --</option>
                <?php foreach ($categories as $categorie): ?>
                    <option value="<?= htmlspecialchars($categorie) ?>"><?= htmlspecialchars($categorie) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="date_event">Date de l'événement :</label>
            <input type="date" id="date_event" name="date_event" required>

            <label for="duree">Durée de l'événement :</label>
            <input type="time" id="duree" name="duree" required>

            <input type="hidden" name="organizer_id" value="<?= $_SESSION['id']; ?>">

            <!-- Le statut est par défaut à "pending" et non modifiable -->
            <input type="hidden" name="status" value="pending">

            <label for="description">Description :</label>
            <textarea id="description" name="description" rows="3" placeholder="Décrivez brièvement votre événement" required></textarea>

            <label for="photo_path">URL de la photo :</label>
            <input type="text" id="photo_path" name="photo_path" placeholder="URL de la photo" required>

            <button type="submit">Organiser l'événement</button>

        </form>
        <br>
        <br>
        <form action="http://localhost/tp-web/mesorganisations.php" method="POST">
            <button type="submit">Back</button>
        </form>
    </div>
</body>
</html>
