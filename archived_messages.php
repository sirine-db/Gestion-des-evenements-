<?php
$servername = "localhost";  
$username = "root";         
$password = "pswd";
$dbname = "dz_events"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve all archived messages
$result = $conn->query("SELECT m.id, m.subject, m.body, m.status, m.sent_at, u.nom, u.adresse_mail
                        FROM messages m
                        JOIN users u ON m.sender_id = u.id
                        WHERE m.status = 'archived'
                        ORDER BY m.sent_at DESC");

$archivedMessages = $result->fetch_all(MYSQLI_ASSOC);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archived Messages</title>
    <link rel="stylesheet" href="message.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <i class="fa fa-user-cog"></i>
            <p id="admin">Admin</p>
        </div>
        <nav>
            <ul>
                <li><a href="menu.php"><i class="fa fa-home"></i>Menu</a></li>
                <li><a href="users.php"><i class="fa fa-users"></i> Utilisateurs</a></li>
                <li><a href="events.php"><i class="fa fa-calendar"></i> Événements</a></li>
                <li><a href="banned.php"><i class="fa fa-ban"></i> Utilisateurs Bannis</a></li>
                <li><a href="request.php"><i class="fa fa-envelope"></i> Demandes d'Événements</a></li>
                <li><a href="message.php"><i class="fa fa-message"></i> Messages</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header>
            <h1>Messages Archivés</h1>
        </header>

        <section id="dashboard-content">
            <div id="messages">
            <a href="message.php" class="back-button">Back</a>
               
                <?php if (count($archivedMessages) > 0): ?>
                    <div id="archived-msgs">
                        <?php foreach ($archivedMessages as $msg): ?>
                            <div class="message-box">
                                <div class="message-header">
                                    <span class="username"><?= htmlspecialchars($msg['nom']) ?> (<?= htmlspecialchars($msg['adresse_mail']) ?>)</span>
                                    <span class="message-time"><?= htmlspecialchars($msg['sent_at']) ?></span>
                                </div>
                                <div class="message-content">
                                    <strong>Sujet:</strong> <?= htmlspecialchars($msg['subject']) ?> <br>
                                    <strong>Contenu:</strong> <?= htmlspecialchars($msg['body']) ?>
                                </div>
                                <div class="message-footer">
                                    <strong>Statut:</strong> <?= htmlspecialchars($msg['status']) ?>
                                </div>
                            </div>
                            <br>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No archived messages found.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>
