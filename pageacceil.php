<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['email'])) {
    // Rediriger vers la page de connexion si non connecté
    header("Location: bienvenue.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DZevent</title>
    <link rel="stylesheet" href="pageaccueil.css">

    
</head>
<body>

  
    <header id="header">
        <nav>
            <ul class="nav-1">
                <li><a href="#hero" >Accueil</a></li>
                <li><a href="#about" >Àpropos</a></li>
                <li><a href="http://localhost/tp-web/event.php">evenements</a></li>
            </ul>
            <ul class="nav-2">
                <li>  <a href="http://localhost/tp-web/login.php">login</a></li>
                <li> <a href="http://localhost/tp-web/signup.php" >sign-up</a></li>
            </ul>
        
        </nav>
    </header>

    <section id="hero" class="hero">
        <div class="hero-content">
            <h1 id="bienvenue">Bienvenue a DZevent</h1>
            <p> Rejoignez la Révolution des Événements en Algérie
                DZevent connecte les passionnés d'événements. Que vous soyez ici pour participer, organiser ou collaborer, découvrez un espace où tout devient possible.</p>
            </p>
            <a href="http://localhost/tp-web/event.php" class="cta-btn">nos evenement</a>
        </div>
    </section>


    <section id="about" class="about">
        <h2>À propos de DZevent</h2>
        <p>DZevent est une plateforme innovante dédiée à connecter organisateurs, participants, et professionnels des événements. Fondée avec l’objectif de dynamiser les événements en Algérie, notre mission est simple : offrir à chacun une expérience inoubliable.</p>
    
        <div class="about-sections">
            <div class="mission">
                <h3>Notre mission</h3>
                <p>Créer des opportunités, faciliter les connexions et rendre chaque événement unique</p>
            </div>
    
            <div class="vision">
                <h3>Notre vision</h3>
                <p>Faire de DZevent le pilier des événements en Algérie</p>
            </div>
    
            <div class="stats">
                <h3>Statistiques clés</h3>
            
                   <p>Plus de <strong>5 000 événements publiés</strong> </p> 
                  <p>Une communauté de <strong>50 000 membres actifs</strong></p>
         
            </div>
        </div>
    </section>
    <footer>
        <p>&copy; 2024 DZevent. Tous droits réservés.</p>
    </footer>

</body>
</html>