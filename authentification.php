<?php

//hna c la connexion a la bdd
//PS: g recuperee les valeur 7tithm f la mm table ly knt ndir
//biha simulation pour pas refaire le travail
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evenement_platform";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}
$utilisateurs_valides = [];
$sql = "SELECT id, nom, prenom, numero_tele, adresse_mail, password, username, role, statut, photo_path,preference FROM users";
$result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $utilisateurs_valides[] = [
            "id" => $row["id"],
            "adresse_mail" => $row["adresse_mail"],
            "username" => $row["username"],
            "numero_tele" => $row["numero_tele"],
            "nom" => $row["nom"],
            "prenom" => $row["prenom"],
            "photo_path"=>$row["photo_path"],
            "statut"=>$row["statut"],
            "password"=>$row["password"],
            "role"=>$row["role"],
            "preference"=>$row["preference"]
            
          
        ];
    }
    

// Récupérer les données du formulaire
$login = $_POST['login'] ;
$password = $_POST['password'];  // Garder le mot de passe tel quel (en clair)

foreach ($utilisateurs_valides as $utilisateur) {
  
    if (($login === $utilisateur['adresse_mail'] || $login === $utilisateur['username']) && 
    password_verify($password, $utilisateur['password'])) 
     { 
        // Démarrer la session
    session_start();
        // Enregistrer les informations utilisateur dans la session
        $_SESSION['id'] = $utilisateur['id'];
        $_SESSION['email'] = $utilisateur['adresse_mail'];
        $_SESSION['username'] = $utilisateur['username'];
        $_SESSION['num'] = $utilisateur['numero_tele'];
        $_SESSION['nom'] = $utilisateur['nom'];
        $_SESSION['prenom'] = $utilisateur['prenom'];
        $_SESSION['preference'] = $utilisateur['preference'];
        $_SESSION['role'] = $utilisateur['role'];
        $_SESSION['statut'] = $utilisateur['statut'];
        $_SESSION['photodeprofile']=$utilisateur['photo_path'];
        if($utilisateur['role']=='user'&&$utilisateur['statut']=='connecte'){
        
            if($utilisateur['preference']==0){
                header("Location: preferencehtml.php");
                exit();}
                else{
                    header("Location: bienvenue.php");
                    exit();
                }
        }
        if($utilisateur['role']=='user'&&$utilisateur['statut']=='bannis'){
                header("Location: login.php");
                exit();
        }
        if($utilisateur['role']=='admin'){
            header("Location: login.php");//TO:DO
            exit();
    }
    }
}

// Si les identifiants sont incorrects, rediriger vers la page de connexion
header("Location: login.php");
exit();
?>
