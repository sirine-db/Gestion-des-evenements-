<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    // Rediriger vers la page de connexion si non connecté
    header("Location: login.php");
    exit();
}
?>
<?php




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
            "nom" => $row["nom"],
            "description" => $row["description"], // Si tu as une description
            "organisateur_id" => $row["organizer_id"],
            "nbr_participants_actuels" => $row["nombre_participant"],
            "lieu" => $row["lieu"],
            "ville" => $row["ville"],
            "date_debut" => $row["date_event"],
            "date_fin" => $row["date_event"], // Ou utilise date_fin si tu as un champ distinct
            "heure_debut" => $row["heure_debut"],
            "heure_fin" => $row["heure_fin"], // Ou utilise un champ horaire de fin si disponible
            "categorie" => $row["categorie"],
            "photos" => $photos, // Ajout des photos de l'événement
        ];
    }
} 
$conn->close();

// Récupération des données soumises par le formulaire
$search_term = isset($_POST['search']) ? $_POST['search'] : '';
$categorie_filter = isset($_POST['categorie']) ? $_POST['categorie'] : '';
$ville_filter = isset($_POST['ville']) ? $_POST['ville'] : '';

// Filtrer les événements en fonction de la recherche et des préférences
$resultats = array_filter($evenements, function($event) use ($search_term, $categorie_filter, $ville_filter) {
    // Charger les préférences de l'utilisateur depuis la session
    $preferences = isset($_SESSION['preferencelist']) ? $_SESSION['preferencelist'] : [];

    // Filtrage des noms ou lieux
    $match_nom = empty($search_term) || stripos($event['nom'], $search_term) !== false || stripos($event['lieu'], $search_term) !== false;

    // Filtrage par catégorie : priorité au filtre du formulaire, sinon préférences
    $match_categorie = empty($categorie_filter)
        ? (empty($preferences) || in_array($event['categorie'], $preferences))
        : $event['categorie'] == $categorie_filter;

    // Filtrage par ville
    $match_ville = empty($ville_filter) || $event['ville'] == $ville_filter;

    // L'événement est valide uniquement si toutes les conditions sont respectées
    return $match_nom && $match_categorie && $match_ville;
});



// Filtrer les événements en fonction de la recherche
$resultats1 = array_filter($evenements, function($event) use ($search_term, $categorie_filter, $ville_filter) {
    $match_nom = empty($search_term) || stripos($event['nom'], $search_term) !== false || stripos($event['lieu'], $search_term) !== false;
    $match_categorie = empty($categorie_filter) || $event['categorie'] == $categorie_filter;
    $match_ville = empty($ville_filter) || $event['ville'] == $ville_filter;

    return $match_nom && $match_categorie && $match_ville;
});

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$events_per_page = 8; // Afficher 8 événements par page
$offset = ($page - 1) * $events_per_page;
$total_pages = ceil(count($resultats) / $events_per_page);
$evenements_pagination = array_slice($resultats, $offset, $events_per_page);


$page1 = isset($_GET['page1']) ? (int)$_GET['page1'] : 1;
$events_per_page1 = 4; // Afficher 8 événements par page
$offset1= ($page1 - 1) * $events_per_page1;
$evenements_pagination1 = array_slice($resultats1, $offset1, $events_per_page1);
$total_pages1 = ceil(count($resultats1) / $events_per_page1);

// Découper les événements en fonction de la pagination

// Calculer le nombre total de pages

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
        #deconnect{
            color:red;
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
        /* En-tête principal */
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
    margin-left: auto; /* Pousse la barre de recherche à l'extrême droite */
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
                <li class="ab">  <a href="http://localhost/tpweb/mesparticipations.php">participations</a></li>
                <li class="ab">  <a href="http://localhost/tpweb/mesorganisations.php">organisation</a></li>
             
             
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

    <div class="profiledeco" id="profiledeco">
            <ul>
            <li><a href="#">Voir mon profil</a></li>
            <li><a href="#">parametres</a></li>
            <li style="color:red;"><a href="deconnexion.php">Déconnexion</a></li>
            </ul>
        </div>

    </header>


   
    <div class="vide"></div>
<br>
<br>
    <h1 id=foryou>Events for you :</h1>    
    
   
<br>
        <div class="events-grid">
        <?php foreach ($evenements_pagination1 as $event): ?>
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
            

            <form action="http://localhost/tpweb/formulaireparticipation.php" method="GET">
               <!-- Champ caché pour l'ID de l'événement -->
    <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
    <input type="hidden" name="photos" value="<?php echo $event['photos'][0]; ?>">
<!-- Champ caché pour le nom de l'événement -->
<input type="hidden" name="nom" value="<?php echo $event['nom']; ?>">

<!-- Champ caché pour la description de l'événement -->
<input type="hidden" name="description" value="<?php echo $event['description']; ?>">

<!-- Champ caché pour l'ID de l'organisateur -->
<input type="hidden" name="organisateur_id" value="<?php echo $event['organisateur_id']; ?>">


<!-- Champ caché pour le nombre de participants actuels -->
<input type="hidden" name="nbr_participants_actuels" value="<?php echo $event['nbr_participants_actuels']; ?>">

<!-- Champ caché pour le lieu de l'événement -->
<input type="hidden" name="lieu" value="<?php echo $event['lieu']; ?>">

<!-- Champ caché pour la ville de l'événement -->
<input type="hidden" name="ville" value="<?php echo $event['ville']; ?>">


<!-- Champ caché pour la date de début -->
<input type="hidden" name="date_debut" value="<?php echo $event['date_debut']; ?>">

<!-- Champ caché pour la date de fin -->
<input type="hidden" name="date_fin" value="<?php echo $event['date_fin']; ?>">

<!-- Champ caché pour l'heure de début -->
<input type="hidden" name="heure_debut" value="<?php echo $event['heure_debut']; ?>">

<!-- Champ caché pour l'heure de fin -->
<input type="hidden" name="heure_fin" value="<?php echo $event['heure_fin']; ?>">

<!-- Champ caché pour la catégorie de l'événement -->
<input type="hidden" name="categorie" value="<?php echo $event['categorie']; ?>">

<!-- Champ caché pour la première photo -->


                <button type="submit">Participer</button>
            </form>

            </div>
        <?php endforeach; ?>
        </div>

        <div class="pagination">
    <?php if ($page1 > 1): ?>
        <a href="javascript:void(0);" onclick="changePage1(<?php echo $page1 - 1; ?>)">Précédent</a>
    <?php endif; ?>
    
    <span>Page <?php echo $page1; ?> sur <?php echo $total_pages1; ?></span>

    <?php if ($page1 < $total_pages1): ?>
        <a href="javascript:void(0);" onclick="changePage1(<?php echo $page1 + 1; ?>)">Suivant</a>
    <?php endif; ?>
</div>
</div>










<h1 id=allevents>All Events :</h1>    
    
   
    <br>
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
                
    
                <form action="http://localhost/tpweb/formulaireparticipation.php" method="GET">
                   <!-- Champ caché pour l'ID de l'événement -->
        <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
        <input type="hidden" name="photos" value="<?php echo $event['photos'][0]; ?>">
    
    <!-- Champ caché pour le nom de l'événement -->
    <input type="hidden" name="nom" value="<?php echo $event['nom']; ?>">
    
    <!-- Champ caché pour la description de l'événement -->
    <input type="hidden" name="description" value="<?php echo $event['description']; ?>">
    
    <!-- Champ caché pour l'ID de l'organisateur -->
    <input type="hidden" name="organisateur_id" value="<?php echo $event['organisateur_id']; ?>">

    
    <!-- Champ caché pour le nombre de participants actuels -->
    <input type="hidden" name="nbr_participants_actuels" value="<?php echo $event['nbr_participants_actuels']; ?>">
    
    <!-- Champ caché pour le lieu de l'événement -->
    <input type="hidden" name="lieu" value="<?php echo $event['lieu']; ?>">
    
    <!-- Champ caché pour la ville de l'événement -->
    <input type="hidden" name="ville" value="<?php echo $event['ville']; ?>">
    

    
    <!-- Champ caché pour la date de début -->
    <input type="hidden" name="date_debut" value="<?php echo $event['date_debut']; ?>">
    
    <!-- Champ caché pour la date de fin -->
    <input type="hidden" name="date_fin" value="<?php echo $event['date_fin']; ?>">
    
    <!-- Champ caché pour l'heure de début -->
    <input type="hidden" name="heure_debut" value="<?php echo $event['heure_debut']; ?>">
    
    <!-- Champ caché pour l'heure de fin -->
    <input type="hidden" name="heure_fin" value="<?php echo $event['heure_fin']; ?>">
    
    <!-- Champ caché pour la catégorie de l'événement -->
    <input type="hidden" name="categorie" value="<?php echo $event['categorie']; ?>">
    
    
                    <button type="submit">Participer</button>
                </form>
    
                </div>
            <?php endforeach; ?>
            </div>
    
            <div class="pagination">
    <?php if ($page > 1): ?>
        <a href="javascript:void(0);" onclick="changePage(<?php echo $page - 1; ?>)">Précédent</a>
    <?php endif; ?>
    
    <span>Page <?php echo $page; ?> sur <?php echo $total_pages; ?></span>

    <?php if ($page < $total_pages): ?>
        <a href="javascript:void(0);" onclick="changePage(<?php echo $page+ 1; ?>)">Suivant</a>
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
   function afficherinfoprofil(x, y) {
            // Récupérer l'élément
            const profiledeco = document.getElementById("profiledeco");
            
            // Changer sa position
            profiledeco.style.top = y + "px"; // Position en Y
            profiledeco.style.left = x + "px"; // Position en X
            
            // Afficher l'élément
            profiledeco.style.display = "block";
        }

        function toggleMenu() {
            const menu = document.getElementById("profiledeco");
            menu.classList.toggle("show");
        }

        // Fermer le menu si on clique ailleurs
        document.addEventListener("click", (event) => {
            const menu = document.getElementById("profiledeco");
            const trigger = document.querySelector(".profile-trigger");

            if (!menu.contains(event.target) && !trigger.contains(event.target)) {
                menu.classList.remove("show");
            }
        });

</script>


<script>
    function changePage1(page1) {
        // Change l'URL sans recharger la page
        history.pushState(null, null, "?page1=" + page1);

        // Recharger le contenu de la page sans changer l'URL
        fetch("?page1=" + page1)
            .then(response => response.text())
            .then(html => {
                // Mettez à jour le contenu de la page avec la nouvelle réponse
                document.body.innerHTML = html;
            });
    }

    function changePage(page) {
        // Change l'URL sans recharger la page
        history.pushState(null, null, "?page=" + page);

        // Recharger le contenu de la page sans changer l'URL
        fetch("?page=" + page)
            .then(response => response.text())
            .then(html => {
                // Mettez à jour le contenu de la page avec la nouvelle réponse
                document.body.innerHTML = html;
            });
    }
</script>



</body>
</html>
