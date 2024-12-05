<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    // Rediriger vers la page de connexion si non connecté
    header("Location: connexion.php");
    exit();
}

// Simuler une base de données d'événements avec des états
$events = [
    ['idevent' => 1,'iduser'=>2, 'status' => 'en cours'],
    ['idevent' => 2,'iduser'=>2, 'status' => 'accepted'],
    ['idevent' => 3,'iduser'=>2, 'status' => 'refused'],
    ['idevent' => 4,'iduser'=>3, 'status' => 'en cours']
];

$utilisateurs = [
    [
        "id" => 1,
        "email" => "admin@mail.com",
        "username" => "admin123",
        "num" => "0777777777",
        "nom" => "Admin",
        "prenom" => "Test",
        "mot_de_passe" => "12345",
        "preference" => 1,
        "preferencelist" => [
            "Musique",
            "professionnels",
            "Atelier"
        ],
         "photo de profile"=>"https://publish-p47754-e237306.adobeaemcloud.com/adobe/dynamicmedia/deliver/dm-aid--914bcfe0-f610-4610-a77e-6ea53c53f630/_330603286208.app.webp?preferwebp=true&width=312"
    ],
    [
        "id" => 2,
        "email" => "user1@mail.com",
        "username" => "user1",
        "num" => "0666666666",
        "nom" => "User",
        "prenom" => "One",
        "mot_de_passe" => "password1",
        "preference" => 1,
        "preferencelist" => [
            "Musique",
            "professionnels",
            "Atelier"
        ],
         "photo de profile"=>"https://publish-p47754-e237306.adobeaemcloud.com/adobe/dynamicmedia/deliver/dm-aid--914bcfe0-f610-4610-a77e-6ea53c53f630/_330603286208.app.webp?preferwebp=true&width=312"
    ],
    [
        "id" => 3,
        "email" => "user2@mail.com",
        "username" => "user2",
        "num" => "0555555555",
        "nom" => "User",
        "prenom" => "Two",
        "mot_de_passe" => "password2",
        "preference" => 0,
        "preferencelist"  => [
            "Musique",
            "professionnels",
            "Atelier"
        ],
         "photo de profile"=>"https://publish-p47754-e237306.adobeaemcloud.com/adobe/dynamicmedia/deliver/dm-aid--914bcfe0-f610-4610-a77e-6ea53c53f630/_330603286208.app.webp?preferwebp=true&width=312"
    ]
];


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

// Événements
$evenements = [
    [
        "id" => 1,
        "nom" => "Séminaire de Marketing",
        "description" => "Un séminaire pour discuter des dernières tendances en marketing.",
        "organisateur_id" => 3,
        "rating" => 4.8,
        "nbr_participants_actuels" => 200,
        "lieu" => "Hôtel X",
        "ville" => "Alger",
        "adresse" => "14.5678, 80.1234",
        "date_debut" => "2024-12-15",
        "date_fin" => "2024-12-15",
        "heure_debut" => "10:00",
        "heure_fin" => "17:00",
        "categorie" => "Séminaire",
        "photos" => [
            "https://img.freepik.com/photos-gratuite/erable-automne-vibrant-laisse-beaute-nature-presentee-generee-par-ia_188544-15039.jpg?t=st=1733219032~exp=1733222632~hmac=13b10163d3692ef7df8e24792cb1e86402a0cab99b80aca2672d032b376493e1&w=996",
            "https://img.freepik.com/vecteurs-libre/illustration-fond-abstrait-fleur-printemps_460848-12688.jpg?t=st=1733219075~exp=1733222675~hmac=d1fcd613d6a8f0428e463694e56b5fec72fbae3a492884d63fe105d87c4f3306&w=740"
        ]
    ],
    [
        "id" => 2,
        "nom" => "Concert de Musique",
        "description" => "Un concert exceptionnel avec des musiciens de renommée.",
        "organisateur_id" => 1,
        "rating" => 4.5,
        "nbr_participants_actuels" => 150,
        "lieu" => "Salle de concert A",
        "ville" => "Alger",
        "adresse" => "12.3456, 78.9012", // GPS
        "date_debut" => "2024-12-10",
        "date_fin" => "2024-12-10",
        "heure_debut" => "18:00",
        "heure_fin" => "22:00",
        "categorie" => "Musique",
        "photos" => [
            "https://img.freepik.com/photos-gratuite/erable-automne-vibrant-laisse-beaute-nature-presentee-generee-par-ia_188544-15039.jpg?t=st=1733219032~exp=1733222632~hmac=13b10163d3692ef7df8e24792cb1e86402a0cab99b80aca2672d032b376493e1&w=996",
            "https://img.freepik.com/vecteurs-libre/illustration-fond-abstrait-fleur-printemps_460848-12688.jpg?t=st=1733219075~exp=1733222675~hmac=d1fcd613d6a8f0428e463694e56b5fec72fbae3a492884d63fe105d87c4f3306&w=740",
            "https://img.freepik.com/photos-gratuite/vue-dessus-arrangement-feuilles-colorees-espace-copie_23-2148831220.jpg?t=st=1733220141~exp=1733223741~hmac=c4e1f7e096128a81d00d930b6f28f3512036f4e5f3757836dc8794967a261653&w=826"
        ]
    ],
    [
        "id" => 3,
        "nom" => "Concert de Musique",
        "description" => "Un concert exceptionnel avec des musiciens de renommée.",
        "organisateur_id" => 1,
        "rating" => 4.5,
        "nbr_participants_actuels" => 150,
        "lieu" => "Salle de concert A",
        "ville" => "Alger",
        "adresse" => "12.3456, 78.9012", // GPS
        "date_debut" => "2024-12-10",
        "date_fin" => "2024-12-10",
        "heure_debut" => "18:00",
        "heure_fin" => "22:00",
        "categorie" => "Musique",
        "photos" => [
            "https://img.freepik.com/photos-gratuite/erable-automne-vibrant-laisse-beaute-nature-presentee-generee-par-ia_188544-15039.jpg?t=st=1733219032~exp=1733222632~hmac=13b10163d3692ef7df8e24792cb1e86402a0cab99b80aca2672d032b376493e1&w=996",
            "https://img.freepik.com/vecteurs-libre/illustration-fond-abstrait-fleur-printemps_460848-12688.jpg?t=st=1733219075~exp=1733222675~hmac=d1fcd613d6a8f0428e463694e56b5fec72fbae3a492884d63fe105d87c4f3306&w=740",
            "https://img.freepik.com/photos-gratuite/vue-dessus-arrangement-feuilles-colorees-espace-copie_23-2148831220.jpg?t=st=1733220141~exp=1733223741~hmac=c4e1f7e096128a81d00d930b6f28f3512036f4e5f3757836dc8794967a261653&w=826"
        ]
    ],
    [
        "id" => 4,
        "nom" => "Concert de Musique",
        "description" => "Un concert exceptionnel avec des musiciens de renommée.",
        "organisateur_id" => 1,
        "rating" => 4.5,
        "nbr_participants_actuels" => 150,
        "lieu" => "Salle de concert A",
        "ville" => "Alger",
        "adresse" => "12.3456, 78.9012", // GPS
        "date_debut" => "2024-12-10",
        "date_fin" => "2024-12-10",
        "heure_debut" => "18:00",
        "heure_fin" => "22:00",
        "categorie" => "Musique",
        "photos" => [
            "https://img.freepik.com/photos-gratuite/erable-automne-vibrant-laisse-beaute-nature-presentee-generee-par-ia_188544-15039.jpg?t=st=1733219032~exp=1733222632~hmac=13b10163d3692ef7df8e24792cb1e86402a0cab99b80aca2672d032b376493e1&w=996",
            "https://img.freepik.com/vecteurs-libre/illustration-fond-abstrait-fleur-printemps_460848-12688.jpg?t=st=1733219075~exp=1733222675~hmac=d1fcd613d6a8f0428e463694e56b5fec72fbae3a492884d63fe105d87c4f3306&w=740",
            "https://img.freepik.com/photos-gratuite/vue-dessus-arrangement-feuilles-colorees-espace-copie_23-2148831220.jpg?t=st=1733220141~exp=1733223741~hmac=c4e1f7e096128a81d00d930b6f28f3512036f4e5f3757836dc8794967a261653&w=826"
        ]
    ],
    [
        "id" => 5,
        "nom" => "Concert de Musique",
        "description" => "Un concert exceptionnel avec des musiciens de renommée.",
        "organisateur_id" => 1,
        "rating" => 4.5,
        "nbr_participants_actuels" => 150,
        "lieu" => "Salle de concert A",
        "ville" => "Alger",
        "adresse" => "12.3456, 78.9012", // GPS
        "date_debut" => "2024-12-10",
        "date_fin" => "2024-12-10",
        "heure_debut" => "18:00",
        "heure_fin" => "22:00",
        "categorie" => "Musique",
        "photos" => [
            "https://img.freepik.com/photos-gratuite/erable-automne-vibrant-laisse-beaute-nature-presentee-generee-par-ia_188544-15039.jpg?t=st=1733219032~exp=1733222632~hmac=13b10163d3692ef7df8e24792cb1e86402a0cab99b80aca2672d032b376493e1&w=996",
            "https://img.freepik.com/vecteurs-libre/illustration-fond-abstrait-fleur-printemps_460848-12688.jpg?t=st=1733219075~exp=1733222675~hmac=d1fcd613d6a8f0428e463694e56b5fec72fbae3a492884d63fe105d87c4f3306&w=740",
            "https://img.freepik.com/photos-gratuite/vue-dessus-arrangement-feuilles-colorees-espace-copie_23-2148831220.jpg?t=st=1733220141~exp=1733223741~hmac=c4e1f7e096128a81d00d930b6f28f3512036f4e5f3757836dc8794967a261653&w=826"
        ]
    ],
    [
        "id" => 6,
        "nom" => "Concert de Musique",
        "description" => "Un concert exceptionnel avec des musiciens de renommée.",
        "organisateur_id" => 1,
        "rating" => 4.5,
        "nbr_participants_actuels" => 150,
        "lieu" => "Salle de concert A",
        "ville" => "Alger",
        "adresse" => "12.3456, 78.9012", // GPS
        "date_debut" => "2024-12-10",
        "date_fin" => "2024-12-10",
        "heure_debut" => "18:00",
        "heure_fin" => "22:00",
        "categorie" => "Musique",
        "photos" => [
            "https://img.freepik.com/photos-gratuite/erable-automne-vibrant-laisse-beaute-nature-presentee-generee-par-ia_188544-15039.jpg?t=st=1733219032~exp=1733222632~hmac=13b10163d3692ef7df8e24792cb1e86402a0cab99b80aca2672d032b376493e1&w=996",
            "https://img.freepik.com/vecteurs-libre/illustration-fond-abstrait-fleur-printemps_460848-12688.jpg?t=st=1733219075~exp=1733222675~hmac=d1fcd613d6a8f0428e463694e56b5fec72fbae3a492884d63fe105d87c4f3306&w=740",
            "https://img.freepik.com/photos-gratuite/vue-dessus-arrangement-feuilles-colorees-espace-copie_23-2148831220.jpg?t=st=1733220141~exp=1733223741~hmac=c4e1f7e096128a81d00d930b6f28f3512036f4e5f3757836dc8794967a261653&w=826"
        ]
    ],
    [
        "id" => 7,
        "nom" => "Concert de Musique",
        "description" => "Un concert exceptionnel avec des musiciens de renommée.",
        "organisateur_id" => 1,
        "rating" => 4.5,
        "nbr_participants_actuels" => 150,
        "lieu" => "Salle de concert A",
        "ville" => "Alger",
        "adresse" => "12.3456, 78.9012", // GPS
        "date_debut" => "2024-12-10",
        "date_fin" => "2024-12-10",
        "heure_debut" => "18:00",
        "heure_fin" => "22:00",
        "categorie" => "Musique",
        "photos" => [
            "https://img.freepik.com/photos-gratuite/erable-automne-vibrant-laisse-beaute-nature-presentee-generee-par-ia_188544-15039.jpg?t=st=1733219032~exp=1733222632~hmac=13b10163d3692ef7df8e24792cb1e86402a0cab99b80aca2672d032b376493e1&w=996",
            "https://img.freepik.com/vecteurs-libre/illustration-fond-abstrait-fleur-printemps_460848-12688.jpg?t=st=1733219075~exp=1733222675~hmac=d1fcd613d6a8f0428e463694e56b5fec72fbae3a492884d63fe105d87c4f3306&w=740",
            "https://img.freepik.com/photos-gratuite/vue-dessus-arrangement-feuilles-colorees-espace-copie_23-2148831220.jpg?t=st=1733220141~exp=1733223741~hmac=c4e1f7e096128a81d00d930b6f28f3512036f4e5f3757836dc8794967a261653&w=826"
        ]
    ],
    [
        "id" => 8,
        "nom" => "Atelier de Photographie",
        "description" => "Un atelier pour apprendre la photographie professionnelle.",
        "organisateur_id" => 2,
        "rating" => 4.0,
        "nbr_participants_actuels" => 50,
        "lieu" => "Studio B",
        "ville" => "Oran",
        "adresse" => "13.4567, 79.0123",
        "date_debut" => "2024-12-12",
        "date_fin" => "2024-12-12",
        "heure_debut" => "09:00",
        "heure_fin" => "15:00",
        "categorie" => "Atelier",
        "photos" => [
            "https://img.freepik.com/photos-gratuite/erable-automne-vibrant-laisse-beaute-nature-presentee-generee-par-ia_188544-15039.jpg?t=st=1733219032~exp=1733222632~hmac=13b10163d3692ef7df8e24792cb1e86402a0cab99b80aca2672d032b376493e1&w=996",
            "https://img.freepik.com/vecteurs-libre/illustration-fond-abstrait-fleur-printemps_460848-12688.jpg?t=st=1733219075~exp=1733222675~hmac=d1fcd613d6a8f0428e463694e56b5fec72fbae3a492884d63fe105d87c4f3306&w=740"
        ]
    ],
    [
        "id" => 9,
        "nom" => "Séminaire de Marketing",
        "description" => "Un séminaire pour discuter des dernières tendances en marketing.",
        "organisateur_id" => 3,
        "rating" => 4.8,
        "nbr_participants_actuels" => 200,
        "lieu" => "Hôtel X",
        "ville" => "Alger",
        "adresse" => "14.5678, 80.1234",
        "date_debut" => "2024-12-15",
        "date_fin" => "2024-12-15",
        "heure_debut" => "10:00",
        "heure_fin" => "17:00",
        "categorie" => "Séminaire",
        "photos" => [
            "https://img.freepik.com/photos-gratuite/erable-automne-vibrant-laisse-beaute-nature-presentee-generee-par-ia_188544-15039.jpg?t=st=1733219032~exp=1733222632~hmac=13b10163d3692ef7df8e24792cb1e86402a0cab99b80aca2672d032b376493e1&w=996",
            "https://img.freepik.com/vecteurs-libre/illustration-fond-abstrait-fleur-printemps_460848-12688.jpg?t=st=1733219075~exp=1733222675~hmac=d1fcd613d6a8f0428e463694e56b5fec72fbae3a492884d63fe105d87c4f3306&w=740"
        ]
    ],
    [
        "id" => 10,
        "nom" => "Séminaire de Marketing",
        "description" => "Un séminaire pour discuter des dernières tendances en marketing.",
        "organisateur_id" => 3,
        "rating" => 4.8,
        "nbr_participants_actuels" => 200,
        "lieu" => "Hôtel X",
        "ville" => "Alger",
        "adresse" => "14.5678, 80.1234",
        "date_debut" => "2024-12-15",
        "date_fin" => "2024-12-15",
        "heure_debut" => "10:00",
        "heure_fin" => "17:00",
        "categorie" => "Séminaire",
        "photos" => [
            "https://img.freepik.com/photos-gratuite/erable-automne-vibrant-laisse-beaute-nature-presentee-generee-par-ia_188544-15039.jpg?t=st=1733219032~exp=1733222632~hmac=13b10163d3692ef7df8e24792cb1e86402a0cab99b80aca2672d032b376493e1&w=996",
            "https://img.freepik.com/vecteurs-libre/illustration-fond-abstrait-fleur-printemps_460848-12688.jpg?t=st=1733219075~exp=1733222675~hmac=d1fcd613d6a8f0428e463694e56b5fec72fbae3a492884d63fe105d87c4f3306&w=740"
        ]
    ],
    [
        "id" => 11,
        "nom" => "Séminaire de Marketing",
        "description" => "Un séminaire pour discuter des dernières tendances en marketing.",
        "organisateur_id" => 3,
        "rating" => 4.8,
        "nbr_participants_actuels" => 200,
        "lieu" => "Hôtel X",
        "ville" => "Alger",
        "adresse" => "14.5678, 80.1234",
        "date_debut" => "2024-12-15",
        "date_fin" => "2024-12-15",
        "heure_debut" => "10:00",
        "heure_fin" => "17:00",
        "categorie" => "Séminaire",
        "photos" => [
            "https://img.freepik.com/photos-gratuite/erable-automne-vibrant-laisse-beaute-nature-presentee-generee-par-ia_188544-15039.jpg?t=st=1733219032~exp=1733222632~hmac=13b10163d3692ef7df8e24792cb1e86402a0cab99b80aca2672d032b376493e1&w=996",
            "https://img.freepik.com/vecteurs-libre/illustration-fond-abstrait-fleur-printemps_460848-12688.jpg?t=st=1733219075~exp=1733222675~hmac=d1fcd613d6a8f0428e463694e56b5fec72fbae3a492884d63fe105d87c4f3306&w=740"
        ]
    ]
];

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
            width: 100%;
            z-index: 1000;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.8);
        }

        header nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        header nav ul li {
            margin: 0 15px;
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

        .event-container {
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

        .event-container h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            background: linear-gradient(90deg, #ff0077, #00f6ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .event {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            transition: background 0.3s ease;
        }

        .event:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .event h3 {
            margin: 0;
            font-size: 1.5rem;
            color: #00f6ff;
        }

        .event p {
            margin: 5px 0;
        }

        .event .date, .event .location, .event .status {
            color: #ff0077;
        }

        .event .status {
            font-weight: bold;
        }

        .event .delete-btn {
            background-color: #ff0077;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .event .delete-btn:hover {
            background-color: #c7005f;
        }

        .event .event-link {
            color: #00f6ff;
            text-decoration: none;
            font-weight: bold;
        }

        .event .event-link:hover {
            text-decoration: underline;
        }






























        body {   margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background: linear-gradient(120deg, #1a1a1d, #4b134f);
    color: white;
    overflow-x: hidden;
        
        #deconnect{
            color:red;
        }
      
        
header {
    background: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    width: 100%;
    padding: 10px 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.8);
    display: flex; /* Active Flexbox */
    align-items: center; /* Aligne les éléments verticalement au centre */
    justify-content: space-between; /* Sépare les éléments : un à gauche, un à droite */
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

    width: 80px; /* Largeur souhaitée */
    height: 80px; /* Hauteur souhaitée (identique à la largeur pour un cercle parfait) */
    border-radius: 50%; /* Rend l'image circulaire */
    object-fit: cover; /* Maintient la qualité de l'image en la recadrant au besoin */
    overflow: hidden; /* Empêche tout débordement */
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

/* Alignement de la barre de recherche */
.search-bar {
    display: flex;
    align-items: center; /* Aligne les champs de recherche verticalement au centre */
    position:absolute; /* Pousse la barre de recherche à l'extrême droite */
    left : 50%;
    top:33%;
}
.profiledeco {
            display: none; /* Caché par défaut */
            position: absolute; /* Permet de positionner avec précision via top et left */
        }
        .profiledeco li {
            list-style: none; /* Supprime les puces des listes */
            margin: 5px 0; /* Espacement vertical entre les éléments */
        }

/* Champs de recherche */
.search-bar input[type="text"],
.search-bar select {
    padding: 10px;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    background: rgba(255, 255, 255, 0.8);
    color: #333;
    transition: all 0.3s ease-in-out;
}

.search-bar input[type="text"]:focus,
.search-bar select:focus {
    background: rgba(255, 255, 255, 1);
    outline: none;
}

/* Bouton de recherche */
.search-bar button {
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    background-color: #00f6ff;
    color: white;
    font-weight: bold;
    margin-left: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
}

.search-bar button:hover {
    background-color: #ff007c;
    color: white;
}


.vide {
    height: 100px;
    width: 100%;
}


/* Effet au survol du bouton */
.search-bar button:hover {
    background: linear-gradient(90deg, #ff007c, #00f6ff);
    transform: translateY(-3px);
}

/* Bouton du profil */
.profile-trigger {
            background-color:transparent;
            color: white;
            border: none;
            padding: 1px 24px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            position: relative;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }


        /* Menu Profil */
        .profiledeco {
            display: none;
            position: absolute;
            top: 110px; /* Position sous le bouton */
            left: 0;
            background-color: #2f3542;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            padding: 15px;
            min-width: 200px;
            z-index: 1000;
        }

        .profiledeco ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .profiledeco li {
            margin: 10px 0;
        }

        .profiledeco a {
            text-decoration: none;
            color: white;
            font-size: 14px;
            font-weight: bold;
            display: block;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        
      
        .profiledeco a:hover {
            background-color: #57606f;
        }

        /* Animation du menu */
        .profiledeco.show {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }






    </style>
</head>
<body>

<header id="header">
        <nav>

            <ul class="nav-2">
            <li>
  <button class="profile-trigger" onclick="toggleMenu()"><img src="<?php echo $_SESSION['photodeprofile']  ?>" alt="pp">
  </button>
            </li>
            <li class="ab"><a href="http://localhost/tpweb/bienvenue.php" >Accueil</a></li>
                <li class="ab">  <a href="">organisation</a></li>
             
             
            </ul>
        
        </nav>
        <div class="container">

       
    <div class="search-bar">
        <form method="POST" action="">
            <input type="text" name="search" placeholder="Rechercher un evenement" />
            <button type="submit">Rechercher</button>
        </form>
    </div>

    <div class="profiledeco" id="profiledeco">
            <ul>
            <li><a href="#">Voir mon profil</a></li>
            <li><a href="#">parametres</a></li>
            <li style="color:red;"><a href="deconnexion.php">Déconnexion</a></li>
            </ul>
        </div>

    </header>

 
    
   
<div class="event-container">
    <h2>Mes Événements</h2>
    
    <!-- Affichage des événements de l'utilisateur connecté -->
    <?php foreach ($events as $event): ?>
        <?php if ($_SESSION['id'] === $event['iduser']): ?>
            <?php
            // Récupérer le titre de l'événement à partir de la base de données des événements
            $eventDetails = null;
            foreach ($evenements as $ev) {
                if ($ev['id'] === $event['idevent']) {
                    $eventDetails = $ev;
                    break;
                }
            }
            ?>
            <?php if ($eventDetails): ?>
                <div class="event">
                    <h3>
                        <a href="eventdetails.php?id=<?php echo $eventDetails['id']; ?>" class="event-link">
                            <?php echo $eventDetails['nom']; ?>
                        </a>
                    </h3>
                    <p class="status">État de la demande : <?php echo $event['status']; ?></p>
                    <form method="POST" action="delete_event.php">
                        <input type="hidden" name="event_id" value="<?php echo $eventDetails['id']; ?>">
                        <button type="submit" class="delete-btn">Supprimer</button>
                    </form>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>

</div>


</div>


</body>
</html>
