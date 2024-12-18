<?php
$servername = "localhost";  
$username = "root";         
$password = "pswd";
$dbname = "dz_events"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for message data
$message = null;
$latestMessages = [];

// Retrieve the 3 most recent messages with user details 
$result = $conn->query("
    SELECT m.id, m.subject, m.body, m.status, m.sent_at, u.nom, u.adresse_mail
    FROM messages m
    JOIN users u ON m.sender_id = u.id
    ORDER BY m.sent_at DESC LIMIT 3
");

if ($result) {
    $latestMessages = $result->fetch_all(MYSQLI_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $id = intval($_POST['ID'] ?? 0);

    if ($action === 'search' && $id > 0) {
        // Search for message by ID
        $stmt = $conn->prepare("SELECT * FROM messages WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $message = $result->fetch_assoc();

        if (!$message) {
            echo "<script>alert('Message not found');</script>";
        }
    } elseif ($action === 'delete' && $id > 0) {
        // Delete message by ID
        $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            echo "<script>alert('Message deleted successfully');</script>";
            // Redirect to the same page after deletion
            echo "<script>window.location.href = window.location.href;</script>";
        } else {
            echo "<script>alert('Failed to delete message');</script>";
        }
    } elseif ($action === 'archive' && $id > 0) {
        // Archive message by ID
        $stmt = $conn->prepare("UPDATE messages SET status = 'archived' WHERE id = ?");
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            echo "<script>alert('Message archived successfully');</script>";
            // Redirect to the same page after archiving
            echo "<script>window.location.href = window.location.href;</script>";
        } else {
            echo "<script>alert('Failed to archive message');</script>";
        }
    } elseif ($action === 'mark_as_read' && $id > 0) {
        // Mark message as read
        $stmt = $conn->prepare("UPDATE messages SET status = 'read' WHERE id = ?");
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            echo "<script>alert('Message marked as read');</script>";
            // Redirect to the same page after marking as read
            echo "<script>window.location.href = window.location.href;</script>";
        } else {
            echo "<script>alert('Failed to mark message as read');</script>";
        }
    } else {
        echo "<script>alert('Invalid action or ID');</script>";
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages Management</title>
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
                <li><a href="participation_requests.php"><i class="fa fa-handshake"></i> Demandes Participations</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header>
            <h1>Messages List</h1>
        </header>

        <section id="dashboard-content">
            <div id="messages">               
                <form method="POST" action="">
                    <div id="buttons">
                        <label for="ID">Message ID</label>
                        <input type="number" name="ID" id="ID" required>
                        <button type="submit" name="action" value="search" id="search">SEARCH</button>
                        <button type="submit" name="action" value="delete" id="delete">DELETE</button>
                        <button type="submit" name="action" value="archive" id="archive">ARCHIVE</button>
                        
                        <button type="submit" name="action" value="mark_as_read" id="mark-as-read">MARK AS READ</button>
                        <a href="archived_messages.php" id="view-archived">messages archivés</a>

                    </div>
                </form>

                <div id="message-info">
                    <?php if (isset($message)) : ?>
                        <p><strong>ID:</strong> <?= htmlspecialchars($message['id']) ?></p>
                        <p><strong>Sender:</strong> <?= htmlspecialchars($message['sender_id']) ?></p>
                        <p><strong>Subject:</strong> <?= htmlspecialchars($message['subject']) ?></p>
                        <p><strong>Body:</strong> <?= htmlspecialchars($message['body']) ?></p>
                        <p><strong>Status:</strong> <?= htmlspecialchars($message['status']) ?></p>
                        <p><strong>Sent At:</strong> <?= htmlspecialchars($message['sent_at']) ?></p>
                    <?php endif; ?>
                </div>
                <div id="last-msg">
                    <?php if (!$message) : ?>
                        <h3>Derniers messages</h3>
                        <div class="message-container">
                            <?php foreach ($latestMessages as $msg) : ?>
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
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </section>
    </main>
</body>
</html>