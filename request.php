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

// Initialize variables
$requests = [];
$request = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Search for a specific event request by ID
    $id = intval($_POST['ID'] ?? 0);
    if ($id > 0) {
        $stmt = $conn->prepare("SELECT r.*, u.nom AS organizer_name FROM event_requests r JOIN users u ON r.organizer_id = u.id WHERE r.id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $request = $result->fetch_assoc();

        if (!$request) {
            echo "<script>alert('Event request not found');</script>";
            echo "<script>window.location.href = 'request.php';</script>"; // Redirect to the same page
        }
    }
} else {
    // Fetch all recent event requests
    $result = $conn->query("SELECT r.id, r.name AS event_name, u.nom AS organizer_name, r.status FROM event_requests r JOIN users u ON r.organizer_id = u.id ORDER BY r.created_at DESC LIMIT 5");
    $requests = $result->fetch_all(MYSQLI_ASSOC);
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="request.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Event Requests</title>
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
        </ul>
    </nav>
</aside>

<main class="main-content">
    <header>
        <h1>Event Requests</h1>
    </header>
    <section id="dashboard-content">
        <div id="requests">
            <!-- Search form -->
            <form method="POST" action="">
                <div id="buttons">
                    <label for="ID">Request ID</label>
                    <input type="number" name="ID" id="ID" required>
                    <button type="submit" id="search" value="search">SEARCH</button>
                </div>
            </form>

            <div id="request-info">
                <?php if (isset($request)): ?>
                    <p><strong>ID:</strong> <?= htmlspecialchars($request['id']) ?></p>
                    <p><strong>Organizer:</strong> <?= htmlspecialchars($request['organizer_name']) ?></p>
                    <p><strong>Event Name:</strong> <?= htmlspecialchars($request['name']) ?></p>
                    <p><strong>Status:</strong> <?= htmlspecialchars($request['status']) ?></p>

                    <a href="details.php?id=<?= $request['id'] ?>" class="details-btn">Details</a>
                <?php else: ?>
                    <p>No request found or search result empty.</p>
                <?php endif; ?>
            </div>

            <div id="recent-requests">
                <h2>Recent Event Requests</h2>
                <?php if (count($requests) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Organizer</th>
                                <th>Event Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($requests as $request): ?>
                                <tr>
                                    <td><?= htmlspecialchars($request['id']) ?></td>
                                    <td><?= htmlspecialchars($request['organizer_name']) ?></td>
                                    <td><?= htmlspecialchars($request['event_name']) ?></td>
                                    <td>
                                        <a href="details.php?id=<?= $request['id'] ?>" class="details-btn">Details</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No recent requests found.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
<footer></footer>
</body>
</html>
