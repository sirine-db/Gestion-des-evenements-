<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    // Rediriger vers la page de connexion si non connecté
    header("Location: login.php");
    exit();
}

// Afficher les informations de l'utilisateur
echo "Bienvenue, " . $_SESSION['prenom'] . " " . $_SESSION['nom'];
echo "<br>Email : " . $_SESSION['email'];
echo "<br>Username : " . $_SESSION['username'];
echo "<br>Numéro : " . $_SESSION['num'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 20%;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Bienvenue, vous êtes connecté(e) !</h1>
    <p><a href="deconnexion.php">Déconnexion </a></p>
 

</body>
</html>
