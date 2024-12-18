<?php
session_start();

// ida l user rh connected wla session ouverte nb3tou bienvenue
if (isset($_SESSION['email'])) {
    header("Location: bienvenue.php");
    exit();
}
?>
<?php
//hna c la connexion a la bdd
//PS: g recuperee les valeur 7tithm f la mm table ly knt ndir
//biha simulation pour pas refaire le travail

// Database connection
$servername = "localhost";
$username = "root";
$password = "pswd";
$dbname = "dz_events";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$utilisateurs_valides = [];
$sql = "SELECT id, nom, prenom, numero_tele, adresse_mail, password, username, role, statut, photo_path FROM users";
$result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $utilisateurs_valides[] = [
            "adresse_mail" => $row["adresse_mail"],
            "username" => $row["username"],
        ];
    }
  

//c bon les donnee sont dans ma table $utilisateurs_valides
// hna jbna les donnee ly tb3tou via la methode post

$id = NULL; // NULL pour que MySQL utilise AUTO_INCREMENT

$mail = $_POST['mail'];
$username = $_POST['username'];
$num = $_POST['num'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe
$role = "user";
$statut = "connecte"; 
$photo_path = "https://i.pinimg.com/736x/1e/05/81/1e05818bf72deae622934d4975db3ede.jpg";

// hna on passe par la table uservalide pour verifier si l utilisateur exist
$user_exists = false;
foreach ($utilisateurs_valides as $utilisateur) {
    if ($mail === $utilisateur['adresse_mail']||$username === $utilisateur['username']) {
        $user_exists = true;
        break;
    }
}

if ($user_exists) {
   //si il existe nb3touh ylogi
   $conn->close();
    header("Location: login.php"); 
    exit();
} else {
       
    $sql = "INSERT INTO users (id, nom, prenom, numero_tele, adresse_mail, password, username, role, statut, photo_path, preference) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt) {
// Valeurs des colonnes
$preference=0;
// Lier les paramètres
    $stmt->bind_param("isssssssssi", $id, $nom, $prenom, $num, $mail, $password, $username, $role, $statut, $photo_path, $preference);

// Exécuter la requête
if ($stmt->execute()) {
    echo "Insertion réussie dans la table users.";
} else {
    echo "Erreur lors de l'insertion : " . $stmt->error;
}

} else {
echo "Erreur de préparation de la requête : " . $conn->error;
}

            $_SESSION['id'] =$id;
            $_SESSION['email'] = $mail;
            $_SESSION['username'] =$username;
            $_SESSION['num'] =$num;
            $_SESSION['nom'] = $nom;
            $_SESSION['prenom'] =$prenom;
            $_SESSION['photodeprofile']=$photo_path;
            $_SESSION['role'] =$role;
            $_SESSION['statut'] =$statut;
            $_SESSION['preference'] =0;
        $conn->close();
        header("Location: preferencehtml.php");
        exit();
}

?>
