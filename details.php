<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "pswd";
$dbname = "dz_events";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch event details
if (isset($_GET['id'])) {
    $eventId = intval($_GET['id']);
    $sql = "SELECT r.*, u.nom AS organizer_name, u.prenom AS organizer_prenom
            FROM event_requests r
            JOIN users u ON r.organizer_id = u.id
            WHERE r.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
} else {
    die("Invalid event ID.");
}

// Handle accept/reject actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accept'])) {
        // Update the status in event_requests to 'accepted'
        $sql = "UPDATE event_requests SET status = 'accepted' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $eventId);
        $stmt->execute();

        // Insert the event into the events table
        $sqlInsert = "INSERT INTO events (name, nombre_participant, lieu, date_event, duree, organizer_id, photo_path, status, description) 
                      SELECT name, nombre_participant, lieu, date_event, duree, organizer_id, photo_path, 'accepted', description 
                      FROM event_requests 
                      WHERE id = ?";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("i", $eventId);
        $stmtInsert->execute();

        // Delete the event from the event_requests table
        $sqlDelete = "DELETE FROM event_requests WHERE id = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $eventId);
        $stmtDelete->execute();

        // Redirect to the event requests page after processing
        header("Location: request.php");
        exit();
    } elseif (isset($_POST['reject'])) {
        // Update the status in event_requests to 'rejected'
        $sql = "UPDATE event_requests SET status = 'rejected' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $eventId);
        $stmt->execute();

        // Delete the event from the event_requests table
        $sqlDelete = "DELETE FROM event_requests WHERE id = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $eventId);
        $stmtDelete->execute();

        // Redirect to the event requests page after processing
        header("Location: request.php");
        exit();
    } elseif (isset($_POST['back'])) {
        // Redirect back to the event requests page without making any changes
        header("Location: request.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="details.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Event Details</title>
</head>
<body>
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

<main class="main-content">
    <header>
        <h1>Event Details</h1>
    </header>

    <section id="event-details">
        <div>
            <p><strong>Name:</strong> <?= htmlspecialchars($event['name']) ?></p>
            <p><strong>Description:</strong> <?= htmlspecialchars($event['description']) ?></p>
            <p><strong>Participants:</strong> <?= htmlspecialchars($event['nombre_participant']) ?></p>
            <p><strong>Lieu:</strong> <?= htmlspecialchars($event['lieu']) ?></p>
            <p><strong>Date:</strong> <?= htmlspecialchars($event['date_event']) ?></p>
            <p><strong>Duration:</strong> <?= htmlspecialchars($event['duree']) ?></p>
        </div>
        <div>
            <img src="<?= htmlspecialchars($event['photo_path']) ?>" alt="Event Photo">
        </div>
    </section>

    <form method="POST">
        <button type="submit" name="accept" id="accept">Accept</button>
        <button type="submit" name="reject" id="reject">Reject</button>
        <button type="submit" name="back" id="back">Back</button>
    </form>
</main>
</body>
</html>

