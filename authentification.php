<?php

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "pswd";
$dbname = "dz_events";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Récupération des utilisateurs depuis la base de données
$utilisateurs_valides = [];
$sql = "SELECT id, nom, prenom, numero_tele, adresse_mail, password, username, role, statut, photo_path, preference FROM users";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $utilisateurs_valides[] = [
            "id" => $row["id"],
            "adresse_mail" => $row["adresse_mail"],
            "username" => $row["username"],
            "numero_tele" => $row["numero_tele"],
            "nom" => $row["nom"],
            "prenom" => $row["prenom"],
            "photo_path" => $row["photo_path"],
            "statut" => $row["statut"],
            "password" => $row["password"],
            "role" => $row["role"],
            "preference" => $row["preference"]
        ];
    }
} else {
    die("Erreur lors de la récupération des utilisateurs : " . $conn->error);
}

// Récupération des données du formulaire
$login = $_POST['login'] ?? null; // Email ou nom d'utilisateur
$password = $_POST['password'] ?? null; // Mot de passe en clair

if (!$login || !$password) {
    header("Location: login.php?error=missing_fields");
    exit();
}


// Vérification des identifiants
foreach ($utilisateurs_valides as $utilisateur) {
    if (($login === $utilisateur['adresse_mail'] || $login === $utilisateur['username']) &&
        password_verify($password, $utilisateur['password'])) {

             // Vérification du statut "bannis"
        if ($utilisateur['statut'] === 'bannis') {
            
            header("Location: login.php?error=banned");
            exit();
        }
        // Démarrer la session
        session_start();

        // Stocker les informations utilisateur dans la session
        $_SESSION['id'] = $utilisateur['id'];
        $_SESSION['email'] = $utilisateur['adresse_mail'];
        $_SESSION['username'] = $utilisateur['username'];
        $_SESSION['num'] = $utilisateur['numero_tele'];
        $_SESSION['nom'] = $utilisateur['nom'];
        $_SESSION['prenom'] = $utilisateur['prenom'];
        $_SESSION['preference'] = $utilisateur['preference'];
        $_SESSION['role'] = $utilisateur['role'];
        $_SESSION['statut'] = $utilisateur['statut'];
        $_SESSION['photodeprofile'] = $utilisateur['photo_path'];

        // Redirection en fonction du rôle et du statut
        if ($utilisateur['role'] === 'user') {
            if ($utilisateur['statut'] === 'bannis') {
                header("Location: login.php?error=banned");
                exit();
            } elseif ($utilisateur['preference'] == 0) {
                header("Location: preferencehtml.php");
                exit();
            } else {
                header("Location: bienvenue.php");
                exit();
            }
        } elseif ($utilisateur['role'] === 'admin') {
            header("Location: menu.php");
            exit();
        }
    }
}

// Si les identifiants sont incorrects
header("Location: login.php?error=invalid_credentials");
exit();

?>
