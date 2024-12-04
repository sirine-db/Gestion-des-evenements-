<?php
// Démarrer la session
session_start();

// Simuler une base de données avec des identifiants valides
$utilisateurs_valides = [
    [
        "email" => "admin@mail.com",
        "username" => "admin123",
        "num" => "0777777777",
        "nom" => "Admin",
        "prenom" => "Test",
        "mot_de_passe" => "12345",
        "preference"=>1
    ],
    [
        "email" => "user1@mail.com",
        "username" => "user1",
        "num" => "0666666666",
        "nom" => "User",
        "prenom" => "One",
        "mot_de_passe" => "password1",
        "preference"=>1
    ],
    [
        "email" => "user2@mail.com",
        "username" => "user2",
        "num" => "0555555555",
        "nom" => "User",
        "prenom" => "Two",
        "mot_de_passe" => "password2",
        "preference"=>0
    ]
];

// Récupérer les données du formulaire
$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';

// Vérification des identifiants
foreach ($utilisateurs_valides as $utilisateur) {
    if (
        ($login === $utilisateur['email'] || $login === $utilisateur['username']) &&
        $password === $utilisateur['mot_de_passe']
    ) {
        // Enregistrer les informations utilisateur dans la session
        $_SESSION['email'] = $utilisateur['email'];
        $_SESSION['username'] = $utilisateur['username'];
        $_SESSION['num'] = $utilisateur['num'];
        $_SESSION['nom'] = $utilisateur['nom'];
        $_SESSION['prenom'] = $utilisateur['prenom'];
        $_SESSION['preference'] = $utilisateur['preference'];
       
        // Redirection vers la page de bienvenue
        if($_SESSION['preference']==1||$_SESSION['preference']==2){
        header("Location: bienvenue.php");
        exit();}
        else{
            header("Location: preferencehtml.php");
            exit();
        }
    }
}

// Si les identifiants sont incorrects, rediriger vers la page de connexion
header("Location: login.php");
echo "Identifiants incorrects";
exit();
?>
