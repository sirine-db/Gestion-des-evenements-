<?php
$servername = "localhost";  
$username = "root";         
$password = "pswd";
$dbname = "dz_events"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Initialize variables

$event_participation =[];
$message = '';  
$participation = null;  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $id = intval($_POST['ID'] ?? 0);

    if ($action === 'search' && $id > 0) {
        // Search for participation request by ID
        $stmt = $conn->prepare("SELECT * FROM event_participation WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $participation = $result->fetch_assoc();

        if (!$participation) {
            $message = 'Participation request not found';
        }
    } elseif ($action === 'accept' && $id > 0) {
        // Accept participation request
        $stmt = $conn->prepare("UPDATE event_participation SET participation_status = 'accepte' WHERE id = ?");
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $message = 'Participation request accepted';
        } else {
            $message = 'Failed to accept participation request';
        }
    } elseif ($action === 'reject' && $id > 0) {
        // Reject participation request
        $stmt = $conn->prepare("UPDATE event_participation SET participation_status = 'rejected' WHERE id = ?");
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $message = 'Participation request rejected';
        } else {
            $message = 'Failed to reject participation request';
        }
    } else {
        $message = 'Invalid action or ID';
    }
}

// Retrieve all participation requests from the database
$stmt = $conn->prepare("SELECT * FROM event_participation");
$stmt->execute();
$result = $stmt->get_result();
$event_participation = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participation Requests</title>
    <link rel="stylesheet" href="partreq.css">
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
                <li><a href="deconnexion.php"><i class="fa fa-sign-out-alt"></i> Déconnexion</a></li>

            </ul>
        </nav>
    </aside>

<main class="main-content">
    <header>
        <h1>Participation Requests</h1>
    </header>

    <section id="dashboard-content">
        <div id="requests">
            <form method="POST" action="">
                <div id="buttons">
                    <label for="ID">Request ID</label>
                    <input type="number" name="ID" id="ID" required>
                    <button type="submit" name="action" value="search" id="search" >SEARCH</button>
                    <button type="submit" name="action" value="accept" id="accept">ACCEPT</button>
                    <button type="submit" name="action" value="reject" id="reject">REJECT</button>
                </div>
            </form>

                <div id="request-info">
                <?php if (isset($participation)) : ?>
                    <p><strong>ID:</strong> <?= htmlspecialchars($participation['id']) ?></p>
                    <p><strong>User ID:</strong> <?= htmlspecialchars($participation['user_id']) ?></p>
                    <p><strong>Event ID:</strong> <?= htmlspecialchars($participation['event_id']) ?></p>
                    <p><strong>Motivation:</strong> <?= htmlspecialchars($participation['motivation']) ?></p>
                    <p><strong>Expectations:</strong> <?= htmlspecialchars($participation['attentes']) ?></p>
                    <p><strong>Status:</strong> <?= htmlspecialchars($participation['participation_status']) ?></p>
                    <p><strong>Statut social:</strong> <?= htmlspecialchars($participation['statut']) ?></p>
                    <p><strong>rajout qlq chose:</strong> <?= htmlspecialchars($participation['rajout']) ?></p>
                    <p><strong>Time:</strong> <?= htmlspecialchars($participation['created_at']) ?></p>
                <?php endif; ?>
            </div>

            <div id="participation_req">
                <h2>All request</h2>
                <?php if (count($event_participation) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User ID:</th>
                                <th>Event ID:</th>
                                <th>Expectations:</th>
                                <th>Status:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($event_participation as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['id']) ?></td>
                                    <td><?= htmlspecialchars($user['user_id']) ?></td>
                                    <td><?= htmlspecialchars($user['event_id']) ?></td>
                                    <td><?= htmlspecialchars($user['attentes']) ?></td>
                                    <td><?= htmlspecialchars($user['participation_status']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No request found.</p>
                <?php endif; ?>
            </div>





        </div>
    </section>
</main>

</body>
</html>
