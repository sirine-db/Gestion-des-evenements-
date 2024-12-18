<?php
$servername = "localhost";  
$username = "root";         
$password = "pswd";
$dbname = "dz_events"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for user data
$user = null;
$message = '';  // Variable to hold success or error messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $id = intval($_POST['ID'] ?? 0);

    if ($action === 'search' && $id > 0) {
        // Search for user by ID
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            $message = 'User not found';
        }
    } elseif ($action === 'delete' && $id > 0) {
        // Delete user by ID
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $message = 'User deleted successfully';
        } else {
            $message = 'Failed to delete user';
        }
    } elseif ($action === 'ban' && $id > 0) {
        // Ban user by ID
        $stmt = $conn->prepare("UPDATE users SET statut = 'bannis' WHERE id = ?");
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $message = 'User banned successfully';
        } else {
            $message = 'Failed to ban user';
                }
        }elseif ($action === 'make_admin' && $id > 0) {
            // Make user an admin
            $stmt = $conn->prepare("UPDATE users SET role = 'admin' WHERE id = ?");
            $stmt->bind_param('i', $id);
            if ($stmt->execute()) {
                $message = 'User role updated to Admin';
            } else {
                $message = 'Failed to update user role';
            }
        } elseif ($action === 'make_organizer' && $id > 0) {
            // Make user an organizer
            $stmt = $conn->prepare("UPDATE users SET role = 'organiser' WHERE id = ?");
            $stmt->bind_param('i', $id);
            if ($stmt->execute()) {
                $message = 'User role updated to Organizer';
            } else {
                $message = 'Failed to update user role';
            }
        } else {
            $message = 'Invalid action or ID';
        }
    }
// Close the connection
$conn->close();
?>



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
    </aside><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management</title>
    <link rel="stylesheet" href="users.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body>
  

    <main class="main-content">
        <header>
            <h1>Users List</h1>
        </header>

        <section id="dashboard-content">
            <div id="userss">
                <form method="POST" action="">
                    <div id="buttons">
                        <label for="ID">ID</label>
                        <input type="number" name="ID" id="ID" required>
                        <button type="submit" name="action" value="search" id="search">SEARCH</button>
                        <button type="submit" name="action" value="delete" id="delete">DELETE</button>
                        <button type="submit" name="action" value="ban" id="ban">BAN</button>
                        <button type="submit" name="action" value="make_admin" id="make_admin">Make Admin</button>
                        <button type="submit" name="action" value="make_organizer" id="make_organizer">Make Organizer</button>
                    </div>
                </form>

                <div id="user-info">
                    <?php if (isset($user)) : ?>
                        <p><strong>ID:</strong> <?= htmlspecialchars($user['id']) ?></p>
                        <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
                        <p><strong>Name:</strong> <?= htmlspecialchars($user['nom']) ?></p>
                        <p><strong>Prenom:</strong> <?= htmlspecialchars($user['prenom']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($user['adresse_mail']) ?></p>
                        <p><strong>Phone:</strong> <?= htmlspecialchars($user['numero_tele']) ?></p>
                        <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
</body>

</html>
