
<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['email'])) {
    // Rediriger vers la page de connexion si non connecté
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Préférences d'événements</title>
    <script>
        // Fonction JavaScript pour vérifier si au moins 3 cases sont sélectionnées
        function validateForm() {
            var checkboxes = document.querySelectorAll('input[name="event[]"]:checked');
            var errorMessage = document.getElementById('error-message');
            
            // Si moins de 3 cases sont sélectionnées
            if (checkboxes.length < 3) {
                // Afficher le message d'erreur
                errorMessage.style.display = 'block';
                return false; // Empêche l'envoi du formulaire
            }
            // Si l'utilisateur a coché au moins 3 cases, on cache l'erreur et on permet l'envoi
            errorMessage.style.display = 'none';
            return true;
        }
       
    </script>
      <style>
        /* Corps général */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1a1a1d, #0d0d0f);
            color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        /* Conteneur principal */
        .container {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(255, 0, 255, 0.2);
            padding: 20px 30px;
            width: 90%;
            max-width: 500px;
            text-align: center;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 15px;
            color: #00f6ff;
            text-shadow: 0 0 10px #00f6ff;
        }

        #error-message {
            color: #ff3860;
            font-size: 0.9rem;
            margin-bottom: 20px;
            display: none;
        }

        /* Style des cases à cocher */
        fieldset {
            border: none;
            margin: 0;
            padding: 0;
            text-align: left;
        }

        legend {
            font-size: 1.2rem;
            margin-bottom: 15px;
            color: #f4f4f9;
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: flex-start;
            text-align: left;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
            color: #fff;
        }

        input[type="checkbox"] {
            accent-color: #ff6f61;
            transform: scale(1.2);
        }

        /* Boutons */
        .form-footer {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }
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

   

        button[type="submit"] {
            background: linear-gradient(90deg, #ff0077, #00f6ff);
            box-shadow: 0 0 10px #ff6f61;
        }

        button[type="submit"]:hover {
            background-color: #ff3860;
            transform: translateY(-3px);
            box-shadow: 0 0 15px #ff3860;
        }

        button[type="button"] {
            background-color: #6a097d;
            box-shadow: 0 0 10px #6a097d;
        }

        button[type="button"]:hover {
            background-color: #a626d3;
            box-shadow: 0 0 15px #a626d3;
        }

        a {
            color: #ff6f61;
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-block;
            margin-top: 15px;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #ff3860;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Choisissez vos préférences d'événements</h1>

        <!-- Message d'erreur, initialement caché -->
         <!-- ici c t grace a display:none -->

        <div id="error-message" style="color: red; display: none; text-align: center; margin-bottom: 20px;">
            Vous devez cocher au moins 3 cases.
        </div>

        <!-- Formulaire -->
        <form action="http://localhost/tpweb/preference.php" method="POST" class="preferences-form" onsubmit="return validateForm()">
            <fieldset>
                <legend>Sélectionnez les événements qui vous intéressent :</legend>

          
                <input type="checkbox" name="event[]" value="professionnels" id="professionnels">
                <label for="professionnels">Événements professionnels</label>
                <br>
                
          
                <input type="checkbox" name="event[]" value="culturels" id="culturels">
                <label for="culturels">Événements culturels</label><br>
                
            
                <input type="checkbox" name="event[]" value="sociaux" id="sociaux">   
                 <label for="sociaux">Événements sociaux</label>
                <br>
                
 
                <input type="checkbox" name="event[]" value="sportifs" id="sportifs">
                <label for="sportifs">Événements sportifs</label><br>
               
                <input type="checkbox" name="event[]" value="éducatifs" id="éducatifs">
                <label for="éducatifs">Événements éducatifs</label><br>
                
         
                <input type="checkbox" name="event[]" value="caritatifs" id="caritatifs">
                <label for="caritatifs">Événements caritatifs</label><br>
                
   
                <input type="checkbox" name="event[]" value="religieux" id="religieux">
                <label for="religieux">Événements religieux</label><br>
                
                <input type="checkbox" name="event[]" value="loisirs" id="loisirs">
                <label for="loisirs">Événements récréatifs</label><br>
                
             
                <input type="checkbox" name="event[]" value="technologiques" id="technologiques">
                <label for="technologiques">Événements technologiques</label><br>
                
            
                <input type="checkbox" name="event[]" value="virtuels" id="virtuels">
                <label for="virtuels">Événements virtuels</label><br>


                <input type="checkbox" name="event[]" value="Musique" id="Musique">
                <label for="Musique">Événements Musique</label><br>
                
             
                <input type="checkbox" name="event[]" value="Atelier" id="Atelier">
                <label for="Atelier">Événements Atelier</label><br>
                
            
                <input type="checkbox" name="event[]" value="Séminaire" id="Séminaire">
                <label for="Séminaire">Événements Séminaire</label><br>
                
                
            </fieldset>
            

            <div class="form-footer">
                <button type="submit">Valider</button>
                <button type="button" onclick="window.location.href='bienvenue.php';">Passer</button>
            </div>
        </form>
        <!--TODO quand il passe on met preference =2!-->
        <p><a href="deconnexion.php">Déconnexion </a></p>
        
    </div>
    
</body>
</html>
