<?php
// Début de la session (si nécessaire)
session_start();

// Utilisateurs
$utilisateurs = [
    [
        "id" => 1,
        "email" => "admin@mail.com",
        "username" => "admin123",
        "num" => "0777777777",
        "nom" => "Admin",
        "prenom" => "Test",
        "mot_de_passe" => "12345",
        "preference" => 1
    ],
    [
        "id" => 2,
        "email" => "user1@mail.com",
        "username" => "user1",
        "num" => "0666666666",
        "nom" => "User",
        "prenom" => "One",
        "mot_de_passe" => "password1",
        "preference" => 1
    ],
    [
        "id" => 3,
        "email" => "user2@mail.com",
        "username" => "user2",
        "num" => "0555555555",
        "nom" => "User",
        "prenom" => "Two",
        "mot_de_passe" => "password2",
        "preference" => 0
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
        "id" => 1,
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
        "id" => 1,
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
        "id" => 1,
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
        "id" => 1,
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
        "id" => 1,
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
        "id" => 2,
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
        "id" => 3,
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
        "id" => 3,
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
        "id" => 3,
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

// Récupération des données soumises par le formulaire
$search_term = isset($_POST['search']) ? $_POST['search'] : '';
$categorie_filter = isset($_POST['categorie']) ? $_POST['categorie'] : '';
$ville_filter = isset($_POST['ville']) ? $_POST['ville'] : '';

// Filtrer les événements en fonction de la recherche
$resultats = array_filter($evenements, function($event) use ($search_term, $categorie_filter, $ville_filter) {
    $match_nom = empty($search_term) || stripos($event['nom'], $search_term) !== false || stripos($event['lieu'], $search_term) !== false;
    $match_categorie = empty($categorie_filter) || $event['categorie'] == $categorie_filter;
    $match_ville = empty($ville_filter) || $event['ville'] == $ville_filter;

    return $match_nom && $match_categorie && $match_ville;
});
?><?php
// Nombre d'événements par page
$events_per_page = 8; // Afficher 3 événements par page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $events_per_page;

// Découper les événements en fonction de la pagination
$evenements_pagination = array_slice($resultats, $offset, $events_per_page);

// Calculer le nombre total de pages
$total_pages = ceil(count($resultats) / $events_per_page);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche d'événements</title>
    <style>
body {   margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background: linear-gradient(120deg, #1a1a1d, #4b134f);
    color: white;
    overflow-x: hidden;
        }
        .container {
            width: 80%;
            margin: auto;
        }
        .search-bar {
            margin: 20px 0;
            text-align: center;
        }
        .events-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 événements par ligne */
            gap: 20px; /* Espacement entre les événements */
            justify-items: center;
        }
        
        .event h2 {
            font-size: 1.6rem;
            text-align: center;
            margin-bottom: 15px;
            color: white;
        }
        .event p {
            color: #ccc;
            font-size: 14px;
            margin: 5px 0;
        }
        .photo-container {
            position: relative;
            width: 100%;
            height: 150px;
            overflow: hidden;
            border-radius: 8px;
        }
        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 100%;
            transition: left 0.5s ease-in-out;
        }
        .photo-container img.active {
            left: 0;
        }
      
        .event {
    background: rgba(255, 255, 255, 0.3);
    padding: 15px;
    border-radius: 8px;
    width: 100%;
    max-width: 400px; /* Limiter la taille des événements */
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Permet au bouton de se placer au bas */
    height: 100%; /* Donne une hauteur flexible au conteneur */
}





.event button {
    width: 100%;
    padding: 12px;
    background: linear-gradient(90deg, #008fbf, #c7005f);
    color: #ffffff;
    border: none;
    border-radius: 5px;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.2s ease;
    margin-top: auto; /* Pousse le bouton en bas */
}

.event button:hover {
    background: linear-gradient(90deg, #c7005f, #008fbf);
    transform: translateY(-3px);
}


        /* Réduire l'espace entre les éléments sur les petits écrans */
        @media (max-width: 768px) {
            .events-grid {
                grid-template-columns: repeat(2, 1fr); /* 2 événements par ligne sur les petits écrans */
            }
        }
        @media (max-width: 480px) {
            .events-grid {
                grid-template-columns: 1fr; /* 1 événement par ligne sur les très petits écrans */
            }
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a {
            color: #e50914;
            text-decoration: none;
            margin: 0 5px;
            font-size: 18px;
        }
        .pagination a:hover {
            text-decoration: underline;
        }
        .pagination span {
            color: #ccc;
            font-size: 18px;
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

header .nav-2 {
   
    position: absolute;
    right: 40px; 
    top: 50%;
    transform: translateY(-50%);
}
/* Style pour la barre de recherche */
.search-bar {
 
}

/* Style pour les champs de recherche */
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

.vide {
    height: 100px;
    width: 100%;
}

/* Style pour le bouton de recherche */
.search-bar button {
    padding: 10px 20px;
    background: linear-gradient(90deg, #00f6ff, #ff007c); /* Dégradé coloré */
    color: #ffffff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s ease, transform 0.2s ease;
}

/* Effet au survol du bouton */
.search-bar button:hover {
    background: linear-gradient(90deg, #ff007c, #00f6ff);
    transform: translateY(-3px);
}


    </style>
</head>
<body>
    
<header id="header">
        <nav>

            <ul class="nav-2">
            <li><a href="http://localhost/tpweb/pageacceil.html#hero" >Accueil</a></li>
                <li>  <a href="http://localhost/tpweb/login.php">login</a></li>
                <li> <a href="http://localhost/tpweb/signup.php" >sign-up</a></li>
            </ul>
        
        </nav>
        <div class="container">
    <div class="search-bar">
        <form method="POST" action="">
            <input type="text" name="search" placeholder="Rechercher par nom ou lieu" value="<?php echo $search_term; ?>" />
            <select name="categorie">
                <option value="">catégorie</option>
                <?php foreach ($categories as $categorie): ?>
                    <option value="<?php echo $categorie; ?>" <?php echo ($categorie_filter == $categorie) ? 'selected' : ''; ?>>
                        <?php echo $categorie; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <select name="ville">
                <option value="">ville</option>
                <?php foreach ($villes as $ville): ?>
                    <option value="<?php echo $ville; ?>" <?php echo ($ville_filter == $ville) ? 'selected' : ''; ?>>
                        <?php echo $ville; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Rechercher</button>
        </form>
    </div>

    </header>
    <div class="vide"></div>


        <div class="events-grid">
        <?php foreach ($evenements_pagination as $event): ?>
            <div class="event">
            <h2><?php echo $event['nom']; ?></h2>
            <div class="photo-container">
                <?php foreach ($event['photos'] as $key => $photo): ?>
                    <img src="<?php echo $photo; ?>" class="<?php echo ($key == 0) ? 'active' : ''; ?>" id="photo-<?php echo $event['id']; ?>-<?php echo $key + 1; ?>" />
                <?php endforeach; ?>
            </div>
            <p><?php echo $event['description']; ?></p>
            <p><strong>Lieu:</strong> <?php echo $event['lieu']; ?>, Ville: <?php echo $event['ville']; ?></p>
            <p><strong>Catégorie:</strong> <?php echo $event['categorie']; ?></p>
            <p><strong>Date:</strong> <?php echo $event['date_debut']; ?> - <?php echo $event['date_fin']; ?></p>
            <p><strong>Heure: </strong><?php echo $event['heure_debut']; ?> - <?php echo $event['heure_fin']; ?></p>
            <p><strong>Participants:</strong> <?php echo $event['nbr_participants_actuels']; ?> participants</p>
            <button>Participer</button>
            </div>
            <?php endforeach; ?>
        </div>



    

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>">Précédent</a>
        <?php endif; ?>

        <span>Page <?php echo $page; ?> sur <?php echo $total_pages; ?></span>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>">Suivant</a>
        <?php endif; ?>
    </div>
</div>

<script>
    document.querySelectorAll('.photo-container').forEach(function(container) {
        let images = container.querySelectorAll('img');
        let currentIndex = 0;

        setInterval(function() {
            images[currentIndex].classList.remove('active');
            currentIndex = (currentIndex + 1) % images.length;
            images[currentIndex].classList.add('active');
        }, 3000);  // Changer d'image toutes les 3 secondes
    });
</script>

</body>
</html>
