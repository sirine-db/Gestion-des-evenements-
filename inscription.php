<?php
session_start();
// Simuler une base de données avec des utilisateurs valides
//date de naissance
$utilisateurs_valides = [
    [
        "email" => "admin@mail.com",
        "username" => "admin123",
        "num" => "0777777777",
        "nom" => "Admin",
        "prenom" => "Test",
        "mot_de_passe" => "12345"
    ],
    [
        "email" => "user1@mail.com",
        "username" => "user1",
        "num" => "0666666666",
        "nom" => "User",
        "prenom" => "One",
        "mot_de_passe" => "password1"
    ],
    [
        "email" => "user2@mail.com",
        "username" => "user2",
        "num" => "0555555555",
        "nom" => "User",
        "prenom" => "Two",
        "mot_de_passe" => "password2"
    ]
];

// Récupérer les données envoyées par le formulaire
$mail = $_POST['mail'] ?? '';
$username = $_POST['username'] ?? '';
$num = $_POST['num'] ?? '';
$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Vérification si l'utilisateur existe déjà
$user_exists = false;
foreach ($utilisateurs_valides as $utilisateur) {
    if ($mail === $utilisateur['email']) {
        $user_exists = true;
        break;
    }
}

if ($user_exists) {
    // Si l'utilisateur existe déjà, redirection vers la page d'accueil
    header("Location: login.php"); //TO:DO amelioration
    exit();
} else {
    // Si l'utilisateur n'existe pas, nous procédons à la création du compte
   
        // Ici vous ajouteriez le code pour insérer l'utilisateur dans la base de données
        // Par exemple : insert_user_into_db($mail, $username, $num, $nom, $prenom, $password);

        // Enregistrer les informations utilisateur dans la session
            $_SESSION['email'] = $mail;
            $_SESSION['username'] =$username;
            $_SESSION['num'] =$num;
            $_SESSION['nom'] = $nom;
            $_SESSION['prenom'] =$prenom;
    
        header("Location: preferencehtml.php");
        exit();
}

?>
