<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    // Redirection vers la page de connexion si non connecté
    header("Location: login.php");
    exit();
}else{
// Récupérer l'ID utilisateur depuis la session
$user_id = $_SESSION['id'];
    }

// Connexion à la base de données
$host = "localhost";
$user = "root";
$password = "pswd";
$dbname = "dz_events";

$conn = new mysqli($host, $user, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérifier si l'ID utilisateur est disponible
if (!isset($_SESSION['id'])) {
    die("Erreur : L'ID utilisateur n'est pas défini dans la session.");
}

// Préparer la requête pour récupérer les participations de l'utilisateur
$sql = "
    SELECT ep.event_id, ep.user_id, ep.participation_status, 
           e.name AS event_name, e.description AS event_description
    FROM event_participation ep
    JOIN events e ON ep.event_id = e.id
    WHERE ep.user_id = ?"; // Utilisation d'un paramètre pour éviter les injections SQL

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); 
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Participations</title>
    <style>
     body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(120deg, #1a1a1d, #4b134f);
    color: #ffffff;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
}
header {
    background: rgba(0, 0, 0, 0.8);
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    width: 100%;
    padding: 30px 500px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.8);
    display: flex; 
    align-items: center; 
    justify-content: space-between;
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
    width: 80px; 
    height: 80px;
    border-radius: 50%;
    object-fit: cover; 
    overflow: hidden; 
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

.event-container {
    position: absolute;
    top: 100px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    padding: 30px 20px;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
    width: 80%;
    max-width: 800px;
    margin-top: 100px;
    box-sizing: border-box;
}

.event-container h2 {
    text-align: center;
    font-size: 2rem;
    margin-bottom: 20px;
    background: linear-gradient(90deg, #ff0077, #00f6ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.event {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
    transition: background 0.3s ease;
}

.event:hover {
    background: rgba(255, 255, 255, 0.3);
}

.event h3 {
    margin: 0;
    font-size: 1.5rem;
    color: #00f6ff;
}

.event p {
    margin: 5px 0;
}

.event .date, .event .location, .event .status {
    color: #ff0077;
}

.event .status {
    font-weight: bold;
}

.event .delete-btn {
    background-color: #ff0077;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.event .delete-btn:hover {
    background-color: #c7005f;
}

.event .event-link {
    color: #00f6ff;
    text-decoration: none;
    font-weight: bold;
}

.event .event-link:hover {
    text-decoration: underline;
}

#deconnect {
    color: red;
}

header nav ul .ab {
    position: relative;
    top: 10px;
}

header nav ul li img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    overflow: hidden;
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

.form-container button {
        width: 100%;
        padding: 12px;
        background: linear-gradient(90deg, #ff0077, #00f6ff);
        color: #ffffff;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .form-container button:hover {
        background: linear-gradient(90deg, #c7005f, #008fbf);
        transform: translateY(-3px);
    }


</style>
</head>
<body>
    <div class="event-container">
        <h2>Liste de mes participations</h2>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="event">
                    <h3>Événement : <?= htmlspecialchars($row['event_name']) ?></h3>
                    <p>Description : <?= htmlspecialchars($row['event_description']) ?></p>
                    <p>État de la participation : <strong><?= htmlspecialchars($row['participation_status']) ?></strong></p>
                    <form action="delete_event.php" method="POST" style="display:inline;">
                        <input type="hidden" name="event_id" value="<?= $row['event_id'] ?>">
                        <button type="submit" class="delete-btn">Supprimer</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Aucune participation trouvée.</p>
        <?php endif; ?>
        <form action="http://localhost/tp-web/pageacceil.php" method="POST" class="form-container">
            <button type="submit" >Back</button>
        </form>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
