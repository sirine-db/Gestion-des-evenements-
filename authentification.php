<?php
// Démarrer la session
session_start();

// Simuler une base de données avec des identifiants valides

    $utilisateurs_valides = [
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
            "photodeprofile"=>"https://publish-p47754-e237306.adobeaemcloud.com/adobe/dynamicmedia/deliver/dm-aid--914bcfe0-f610-4610-a77e-6ea53c53f630/_330603286208.app.webp?preferwebp=true&width=312"
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
             "photodeprofile"=>"https://publish-p47754-e237306.adobeaemcloud.com/adobe/dynamicmedia/deliver/dm-aid--914bcfe0-f610-4610-a77e-6ea53c53f630/_330603286208.app.webp?preferwebp=true&width=312"
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
            "preferencelist" => [
                "Musique",
                "professionnels",
                "Atelier"
            ],
             "photodeprofile"=>"https://publish-p47754-e237306.adobeaemcloud.com/adobe/dynamicmedia/deliver/dm-aid--914bcfe0-f610-4610-a77e-6ea53c53f630/_330603286208.app.webp?preferwebp=true&width=312"
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
        $_SESSION['id'] = $utilisateur['id'];
        $_SESSION['email'] = $utilisateur['email'];
        $_SESSION['username'] = $utilisateur['username'];
        $_SESSION['num'] = $utilisateur['num'];
        $_SESSION['nom'] = $utilisateur['nom'];
        $_SESSION['prenom'] = $utilisateur['prenom'];
        $_SESSION['preference'] = $utilisateur['preference'];
        $_SESSION['preferencelist']=$utilisateur['preferencelist'];
        $_SESSION['photodeprofile']=$utilisateur['photodeprofile'];
       
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
exit();
?>
