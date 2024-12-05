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
    <title>Formulaire d'Inscription</title>
    <style>
        /* Styles globaux */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(120deg, #1a1a1d, #4b134f);
            background-attachment: fixed;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Conteneur principal */
        .form-container {
            position: relative; /* Définir la position relative de l'élément */
            top: 40px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 30px 20px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;  
            height: 100%; 
            max-height:800px;
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
                <li><a href="http://localhost/tpweb/pageacceil.php#hero" >Accueil</a></li>
                <li><a href="http://localhost/tpweb/event.php">evenements</a></li>
                <li><a href="http://localhost/tpweb/pageacceil.php#about" >Àpropos</a></li>
                <li><a href="http://localhost/tpweb/pageacceil.php#contact">Contact</a></li>
            </ul>
            <ul class="nav-2">
                <li>  <a href="http://localhost/tpweb/login.php">login</a></li>
             
            </ul>
        
        </nav>
    </header>
    <div class="form-container">
        <h2>Inscription</h2>
        <a href="http://localhost/tpweb/login.php">Déjà inscrit ? Connectez-vous</a>
        <form action="http://localhost/tpweb/inscription.php" method="POST" onsubmit="return validateForm()">
            <input type="text" id="mail" name="mail" placeholder="Email (ex: exemple@mail.com)" required>
            <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" required>
            <input type="text" id="num" name="num" placeholder="Numéro de téléphone (ex: 0777777777)" required>
            <input type="text" id="nom" name="nom" placeholder="Nom" required>
            <input type="text" id="prenom" name="prenom" placeholder="Prénom" required>
            <input type="password" id="password" name="password" placeholder="Mot de passe" required>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmer le mot de passe" required>
            <button type="submit">S'inscrire</button>
        </form>
        <p id="msgerr"></p>
    </div>

    <script>
        function validateForm() {
            const num = document.getElementById("num").value;
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            const errorMsg = document.getElementById("msgerr");

            // Vérification du numéro de téléphone
            const phoneRegex = /^(07|06|05)\d{8}$/;
            if (!phoneRegex.test(num)) {
                errorMsg.textContent = "Le numéro de téléphone doit commencer par 07, 06 ou 05 et contenir exactement 10 chiffres.";
                return false;
            }

            // Vérification du mot de passe
            const passwordRegex = /^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*[a-zA-Z]).{8,}$/;
            if (!passwordRegex.test(password)) {
                errorMsg.textContent = "Le mot de passe doit contenir au moins 8 caractères, une majuscule et un caractère spécial.";
                return false;
            }

            // Vérification de la correspondance des mots de passe
            if (password !== confirmPassword) {
                errorMsg.textContent = "Les mots de passe ne correspondent pas.";
                return false;
            }

            errorMsg.textContent = ""; // Efface le message d'erreur
            return true;
        }
    </script>
</body>
</html>
