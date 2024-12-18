<?php
session_start();

$successMessage = ""; 

// Connexion à la base de données
$host = "localhost";
$username = "root";
$password = "pswd";
$dbname = "dz_events";
$conn = new mysqli($host, $username, $password, $dbname);

// Vérification de la connexion à la base de données
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Redirection après login pour renvoyer le message
if (isset($_SESSION['temp_message'])) {
    $temp_message = $_SESSION['temp_message'];
    unset($_SESSION['temp_message']); 
} else {
    $temp_message = null;
}

// Récupérer les informations de l'utilisateur connecté
$user_name = "";
$user_email = "";

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    
    // Requête pour récupérer le nom complet et l'email de l'utilisateur
    $query = "SELECT nom, prenom, adresse_mail FROM users WHERE id = '$user_id'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        $user_name = htmlspecialchars($user_data['nom'] . ' ' . $user_data['prenom']);
        $user_email = htmlspecialchars($user_data['adresse_mail']);
    }
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['id'])) {
        // Récupérer les données du formulaire
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $sender_id = $_SESSION['id'];
        $status = "unread";
        $sent_at = date("Y-m-d H:i:s");

        // Requête pour insérer les données dans la table "messages"
        $sql = "INSERT INTO messages (sender_id, subject, body, sent_at, status, sender_name, adresse_mail)
                VALUES ('$sender_id', '$subject', '$message', '$sent_at', '$status', '$name','$email')";

        if ($conn->query($sql) === TRUE) {
            $successMessage = "Message envoyé avec succès.";
            echo "<script>alert('$successMessage'); window.location.href = 'bienvenue.php';</script>";
            exit();
        } else {
            $successMessage = "Erreur : " . $conn->error;
        }
    } else {
        // Si l'utilisateur n'est pas connecté, sauvegarder temporairement les données
        $_SESSION['temp_message'] = $_POST;
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous</title>
    <link rel="stylesheet" href="pageaccueil.css">
</head>
<body>
<header id="header">
    <nav>
        <ul class="nav-1">
            <li><a href="bienvenue.php">Accueil</a></li>
            <li><a href="event.php">Événements</a></li>
        </ul>
        <ul class="nav-2">
            <?php if (isset($_SESSION['id'])): ?>
                <li><a href="deconnexion.php">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="signup.php">Sign-up</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<section id="contact" class="contact">
    <h2>Contactez notre administration</h2>
    <p>Vous avez une question ? Une suggestion ? Notre équipe est à votre écoute !</p>
    <?php if ($successMessage): ?>
        <p style="color: green;"><?php echo htmlspecialchars($successMessage); ?></p>
    <?php endif; ?>

    <form id="contact-form" method="POST" action="contact.php">
    <input type="text" name="name" placeholder="Votre nom" value="<?php echo $user_name; ?>" required>
    <input type="email" name="email" placeholder="Votre email" value="<?php echo $user_email; ?>" required>
        <input type="text" name="subject" placeholder="Sujet" value="<?php echo $temp_message['subject'] ?? ''; ?>" required>
        <textarea name="message" placeholder="Votre message" required><?php echo $temp_message['message'] ?? ''; ?></textarea>
        <button type="submit" class="submit-btn">Envoyer</button>
    </form>
</section>
</body>
</html>
