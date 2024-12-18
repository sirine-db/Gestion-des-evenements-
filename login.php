<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['email'])) {
    // Rediriger vers la page de connexion si non connecté
    header("Location: bienvenue.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(120deg, #1a1a1d, #4b134f);
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Conteneur principal */
        .form-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px 20px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }

        .form-container h2 {
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 15px;
            background: linear-gradient(90deg, #ff0077, #00f6ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-container a {
            color: #00f6ff;
            text-decoration: none;
            font-size: 0.9rem;
            display: block;
            text-align: center;
            margin-bottom: 15px;
        }

        .form-container a:hover {
            color: #ff0077;
        }

        /* Champs de saisie */
        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            font-size: 1rem;
            box-sizing: border-box;
            transition: border-color 0.3s ease, background 0.3s ease;
        }

        .form-container input:focus {
            border-color: #00f6ff;
            background: rgba(255, 255, 255, 0.3);
            outline: none;
        }


        /* Bouton */
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

        /* Message d'erreur */
        #msgerr {
            color: red;
            text-align: center;
            font-size: 0.9rem;
        }


            header {
        background: rgba(0, 0, 0, 0.8);
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.8);
    }

    header nav ul {
        list-style: none;
        display: flex;
        margin: 0;
        padding: 0;
    }

    header nav ul li {
        margin: 0 15px;
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

    header .nav-2 {
    
        position: absolute;
        right: 40px; 
        top: 50%;
        transform: translateY(-50%);
    }

    </style>
</head>
<body>

<header id="header">
        <nav>
            <ul class="nav-1">
                <li><a href="http://localhost/tp-web/pageacceil.php#hero" >Accueil</a></li>
                <li><a href="http://localhost/tp-web/event.php">evenements</a></li>
                <li><a href="http://localhost/tp-web/pageacceil.php#about" >Àpropos</a></li>
            </ul>
            <ul class="nav-2">

                <li> <a href="http://localhost/tp-web/signup.php" >sign-up</a></li>
            </ul>
        
        </nav>
    </header>
    <div class="form-container">
        <h2>Connexion</h2>
        <a href="http://localhost/tp-web/signup.php">Pas encore inscrit ? Créez un compte</a>
        <form action="http://localhost/tp-web/authentification.php" method="POST">
            <label for="login">Email :</label>
            <input type="text" id="login" name="login" placeholder="exemple@mail.com" required>
            
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
            
            <button type="submit">Se connecter</button>
        </form>
        <p id="msgerr"></p>
    </div>
</body>
</html>
