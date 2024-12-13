<?php
// Début de la session (si nécessaire)
session_start();


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

// Événements$servername = "localhost";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evenement_platform";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}
$evenements = [];

$sql = "SELECT * FROM events"; // Sélectionner tous les événements
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Boucle pour parcourir tous les événements récupérés
    while ($row = $result->fetch_assoc()) {
        // On récupère les photos de l'événement
        $photo_sql = "SELECT photo_url FROM event_photos WHERE event_id = " . $row['id'];
        $photo_result = $conn->query($photo_sql);
        $photos = [];
        
        if ($photo_result->num_rows > 0) {
            while ($photo_row = $photo_result->fetch_assoc()) {
                $photos[] = $photo_row['photo_url']; // Ajoute chaque photo à l'array
            }
        }
        // Ajouter l'événement à la table $evenements
        $evenements[] = [
            "id" => $row["id"],
            "nom" => $row["name"],
            "description" => $row["description"], // Si tu as une description
            "organisateur_id" => $row["organizer_id"],
            "rating" => $row["rating"],
            "nbr_participants_actuels" => $row["nombre_participant"],
            "lieu" => $row["lieu"],
            "ville" => $row["ville"],
            "adresse" => $row["adresse"], // GPS
            "date_debut" => $row["date_event"],
            "date_fin" => $row["date_event"], // Ou utilise date_fin si tu as un champ distinct
            "heure_debut" => $row["duree"],
            "heure_fin" => $row["duree"], // Ou utilise un champ horaire de fin si disponible
            "categorie" => $row["categorie"],
            "photos" => $photos, // Ajout des photos de l'événement
        ];
    }
} else {
    echo "Aucun événement trouvé.";
}

$conn->close();



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
            <li><a href="http://localhost/tpweb/pageacceil.php#hero" >Accueil</a></li>
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
            <button onclick="window.location.href='http://localhost/tpweb/login.php'">Participer</button>


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
