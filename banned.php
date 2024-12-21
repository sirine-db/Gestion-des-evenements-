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
$users = [];
$user = null;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Unban a user
    if (isset($_POST['unban_id'])) {
        $unban_id = intval($_POST['unban_id']);
        if ($unban_id > 0) {

            $stmt = $conn->prepare("UPDATE users SET statut = 'connecté' WHERE id = ?");
            $stmt->bind_param('i', $unban_id);
            $stmt->execute();
            echo "<script>alert('User has been unbanned');</script>";
            
            header("Location: banned.php");
            exit(); 
        }
    }

    // Search for banned user by ID
    $id = intval($_POST['ID'] ?? 0);
    if ($id > 0) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ? AND statut = 'bannis'");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            $error_message = 'User not found or not banned';
        }
    }
} else {
    $result = $conn->query("SELECT * FROM users WHERE statut = 'bannis'");
    $users = $result->fetch_all(MYSQLI_ASSOC);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="banned.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Banned Users</title>
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
            <li><a href="deconnexion.php"><i class="fa fa-sign-out-alt"></i> Déconnexion</a></li>
        </ul>
    </nav>
</aside>

<main class="main-content">
    <header>
        <h1>Banned Users</h1>
    </header>
    <section id="dashboard-content">
        <div id="userss">
            <form method="POST" action="">
                <div id="buttons">
                    <label for="ID">ID</label>
                    <input type="number" name="ID" id="ID" required>
                    <button type="submit" id="search" value="search">SEARCH</button>
                </div>
            </form>
            
            <div id="user-info">
                <?php if (isset($user)): ?>
                    <p><strong>ID:</strong> <?= htmlspecialchars($user['id']) ?></p>
                    <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
                    <p><strong>Name:</strong> <?= htmlspecialchars($user['nom']) ?></p>
                    <p><strong>Prenom:</strong> <?= htmlspecialchars($user['prenom']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($user['adresse_mail']) ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($user['numero_tele']) ?></p>
                    <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>

                    <!-- Unban button -->
                    <form method="POST" action="">
                        <input type="hidden" name="unban_id" id="unban" value="<?= htmlspecialchars($user['id']) ?>">
                        <button type="submit" id="unban">Unban</button>
                    </form>
                <?php else: ?>
                    <p><?= $error_message ?: 'No user found or search result empty.' ?></p>
                <?php endif; ?>
            </div>

            <div id="banned-users-list">
                <h2>All Banned Users</h2>
                <?php if (count($users) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['id']) ?></td>
                                    <td><?= htmlspecialchars($user['username']) ?></td>
                                    <td><?= htmlspecialchars($user['nom']) ?></td>
                                    <td><?= htmlspecialchars($user['adresse_mail']) ?></td>
                                    <td><?= htmlspecialchars($user['role']) ?></td>
                                    <td>
                                        <!-- Unban button for each user -->
                                        <form method="POST" action="">
                                            <input type="hidden" name="unban_id" value="<?= htmlspecialchars($user['id']) ?>">
                                            <button type="submit" id="unban">Unban</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No banned users found.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
<footer></footer>
</body>
</html>
