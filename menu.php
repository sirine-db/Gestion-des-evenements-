<?php
$servername = "localhost";
$username = "root";
$password = "pswd";
$dbname = "dz_events";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les statistiques
$totalUsers = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$approvedEvents = $conn->query("SELECT COUNT(*) as count FROM events WHERE status = 'accepted'")->fetch_assoc()['count'];
$bannedUsers = $conn->query("SELECT COUNT(*) as count FROM users WHERE statut = 'bannis'")->fetch_assoc()['count'];
$pendingRequests = $conn->query("SELECT COUNT(*) as count FROM event_requests WHERE status = 'pending'")->fetch_assoc()['count'];

// Récupérer les notifications
$notifications = [];
$notifications[] = "$pendingRequests nouvelles demandes d’événements.";
if ($pendingRequests > 0) {
    $latestRequest = $conn->query("SELECT name FROM event_requests WHERE status = 'pending' ORDER BY created_at DESC LIMIT 1")->fetch_assoc()['name'];
    $notifications[] = "Demande d’événement : \"$latestRequest\" (en attente).";
}
$newUser = $conn->query("SELECT nom, prenom FROM users ORDER BY id DESC LIMIT 1")->fetch_assoc();
if ($newUser) {
    $notifications[] = "Nouvel utilisateur : " . $newUser['nom'] . " " . $newUser['prenom'] . ".";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="menu.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"> 
    <title>Tableau DE BORD</title>
</head>
<body>
    
<aside class="sidebar">
    <div class="logo">
        <i class="fa fa-user-cog"></i>
        <p id="admin">Admin</p>
    </div>

    <nav>
        <ul>
            <li><a href="menu.php" id="menu-tab"><i class="fa fa-home"></i>Menu</a></li>
            <li><a href="users.php" id="users-tab"><i class="fa fa-users"></i> Utilisateurs</a></li>
            <li><a href="events.php" id="events-tab"><i class="fa fa-calendar"></i> Événements</a></li>
            <li><a href="banned.php" id="banned-tab"><i class="fa fa-ban"></i> Utilisateurs Bannis</a></li>
            <li><a href="request.php" id="requests-tab"><i class="fa fa-envelope"></i> Demandes d’Événements</a></li>
            <li><a href="message.php" id="message-tab"><i class="fa fa-message"></i> Messages</a></li>
        </ul>
    </nav>
</aside>

<main class="main-content">
    <header>
        <h1>Tableau De Bord</h1>
    </header>

    <section id="dashboard-content">
        <div id="Tableau-de-bord">
            <div class="stats-row">
                <div id="users">
                    <h3>Total Utilisateurs</h3>
                    <p><?php echo $totalUsers; ?></p>
                </div>
                <div id="events">
                    <h3>Événements Approuvés</h3>
                    <p><?php echo $approvedEvents; ?></p>
                </div>
                <div id="banned">
                    <h3>Utilisateurs Bannis</h3>
                    <p><?php echo $bannedUsers; ?></p>
                </div>
                <div id="requests">
                    <h3>Demandes en Attente</h3>
                    <p><?php echo $pendingRequests; ?></p>
                </div>
            </div>
            <div id="notifications">   
                <h3>Notifications</h3>
                <?php foreach ($notifications as $notification): ?>
                    <p><?php echo $notification; ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
<script src="menu.js"></script>

<footer></footer>
</body>
</html>

<?php
$conn->close();
?>
