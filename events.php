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

// Function to search event by ID
function searchEvent($eventId) {
    global $conn;
    $sql = "SELECT * FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventId);  // 'i' stands for integer
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null; // Event not found
    }
}

// Function to delete event by ID
function deleteEvent($eventId) {
    global $conn;
    $sql = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventId);  // 'i' stands for integer
    
    return $stmt->execute();
}

function updateEvent($eventId, $name, $participants, $location, $date, $duration, $organizer) {
    global $conn;

    // Vérifier si l'ID de l'organisateur existe et s'il n'est pas banni
    $sql = "SELECT id, statut FROM users WHERE id = ? AND statut != 'bannis'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $organizer);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si l'ID de l'organisateur n'existe pas ou s'il est banni
    if ($result->num_rows === 0) {
        return "L'ID de l'organisateur n'existe pas ou il est banni.";
    }

    // Si l'ID existe et l'utilisateur n'est pas banni, mettre à jour l'événement
    $sql = "UPDATE events SET name = ?, nombre_participant = ?, lieu = ?, date_event = ?, duree = ?, organizer_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sissssi", $name, $participants, $location, $date, $duration, $organizer, $eventId);

    return $stmt->execute() ? true : false;
}

// Handle Search Request
$event = null;
if (isset($_POST['search'])) {
    $eventId = $_POST['ID'];
    $event = searchEvent($eventId);
}

// Handle Delete Request
if (isset($_POST['delete'])) {
    $eventId = $_POST['ID'];
    if (deleteEvent($eventId)) {
        echo "<script>alert('Event deleted successfully!');</script>";
    } else {
        echo "<script>alert('Failed to delete the event.');</script>";
    }
}

// Handle Update Request
if (isset($_POST['update'])) {
    $eventId = $_POST['ID'];

    // Ensure all variables are defined before use
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $nombre_participant = isset($_POST['nombre_participant']) ? $_POST['nombre_participant'] : '';
    $lieu = isset($_POST['lieu']) ? $_POST['lieu'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $duration = isset($_POST['duration']) ? $_POST['duration'] : '';
    $organizer = isset($_POST['organizer']) ? $_POST['organizer'] : '';

    // Check that fields are not empty
    if (!empty($name) && !empty($nombre_participant) && !empty($lieu) && !empty($date) && !empty($duration) && !empty($organizer)) {
        $updateResult = updateEvent($eventId, $name, $nombre_participant, $lieu, $date, $duration, $organizer);
        
        if ($updateResult === true) {
            echo "<script>alert('Event updated successfully!');</script>";
            // Redirection vers la même page pour recharger les informations mises à jour
            header("Location: events.php");
            exit;
        } elseif ($updateResult === "L'ID de l'organisateur n'existe pas.") {
            echo "<script>alert('L\'ID de l\'organisateur n\'existe pas.');</script>";
        } else {
            echo "<script>alert('Failed to update the event.');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all fields.');</script>";
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="events.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Event Management</title>
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
            <li><a href="request.php" id="requests-tab"><i class="fa fa-envelope"></i> Demandes d'Événements</a></li>
            <li><a href="message.php" id="message-tab"><i class="fa fa-message"></i> Messages</a></li>
            <li><a href="participation_requests.php"><i class="fa fa-handshake"></i> Demandes Participations</a></li>

        </ul>
    </nav>
</aside>

<main class="main-content">
    <header>
        <h1>Events List</h1>
    </header>

    <section id="dashboard-content">
        <div id="events">
            <div id="buttons">
                <form method="POST" action="events.php">
                    <label for="ID">ID</label>
                    <input type="number" name="ID" id="ID" required>
                    <button type="submit" name="search" id="search">SEARCH</button>
                    <button type="submit" name="delete" id="delete">DELETE</button>
                    <button type="button" id="edit" onclick="document.getElementById('event-update-form').style.display='block'; this.style.display='none';">Edit Event</button>
                </form>
            </div>
            
            <?php if ($event): ?>
                <div id="event-info">
                    <p><strong>ID:</strong> <?= $event['id'] ?></p>
                    <p><strong>NAME:</strong> <?= $event['name'] ?></p>
                    <p><strong>PARTICIPANTS:</strong> <?= $event['nombre_participant'] ?></p>
                    <p><strong>LOCATION:</strong> <?= $event['lieu'] ?></p>
                    <p><strong>DATE:</strong> <?= $event['date_event'] ?></p>
                    <p><strong>DURATION:</strong> <?= $event['duree'] ?></p>
                    <p><strong>ORGANIZER:</strong> <?= $event['organizer_id'] ?></p>
                </div>

                <div id="event-update-form" style="display:none;">
                    <form method="POST" action="events.php">
                        <input type="hidden" name="ID" value="<?= $event['id'] ?>"> <!-- Hidden field for event ID -->
                        <p><strong>NAME:</strong><input type="text" name="name" value="<?= $event['name'] ?>" required></p>
                        <p><strong>PARTICIPANTS:</strong><input type="number" name="nombre_participant" value="<?= $event['nombre_participant'] ?>" required></p>
                        <p><strong>LOCATION:</strong><input type="text" name="lieu" value="<?= $event['lieu'] ?>" required></p>
                        <p><strong>DATE:</strong><input type="date" name="date" value="<?= $event['date_event'] ?>" required></p>
                        <p><strong>DURATION:</strong><input type="time" name="duration" value="<?= $event['duree'] ?>" required></p>
                        <p><strong>ORGANIZER:</strong><input type="text" name="organizer" value="<?= $event['organizer_id'] ?>" required></p>
                        
                        <button type="submit" name="update" style="background-color: #002930; color: white"; style.display='block'; this.style.display='none';"">Save Changes</button>
                        </form>
                </div>
            <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])): ?>
                <p>Event not found!</p>
            <?php endif; ?>
        </div>
    </section>
</main>

</body>
</html>
