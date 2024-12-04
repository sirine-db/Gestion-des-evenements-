<?php
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //hna lezm ndir bly session[preference]=1 w bly value t3 preference twly 1 t3 l user f bdd w modif bdd pour les preferences
  //maybe nzid ida =2 m3ntha he choosed to pass preferences
        $events = $_POST["event[]"];

        foreach ($events as $event) {
       switch ($event) {
                case "professionnels":
                    echo "Vous avez sélectionné un événement professionnel.<br>";
                    break;
                case "culturels":
                    echo "Vous avez sélectionné un événement culturel.<br>";
                    break;
                case "sociaux":
                    echo "Vous avez sélectionné un événement social.<br>";
                    break;
                case "sportifs":
                    echo "Vous avez sélectionné un événement sportif.<br>";
                    break;
                case "éducatifs":
                    echo "Vous avez sélectionné un événement éducatif.<br>";
                    break;
                case "caritatifs":
                    echo "Vous avez sélectionné un événement caritatif.<br>";
                    break;
                case "religieux":
                    echo "Vous avez sélectionné un événement religieux.<br>";
                    break;
                case "loisirs":
                    echo "Vous avez sélectionné un événement récréatif.<br>";
                    break;
                case "technologiques":
                    echo "Vous avez sélectionné un événement technologique.<br>";
                    break;
                case "virtuels":
                    echo "Vous avez sélectionné un événement virtuel.<br>";
                    break;
                case "Séminaire":
                        echo "Vous avez sélectionné un événement Séminaire.<br>";
                    break;
                case "Musique":
                        echo "Vous avez sélectionné un événement Musique.<br>";
                    break;
                case "Atelier":
                        echo "Vous avez sélectionné un événement Atelier.<br>";
                break;
               
            
                    
                    
                    
            }
        }
        header("Location: bienvenue.php");
        exit();
    }

    
?>


