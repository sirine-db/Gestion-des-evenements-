<?php
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  //hna lezm ndir bly session[preference]=1 w bly value t3 preference twly 1 t3 l user f bdd w modif bdd pour les preferences
  //maybe nzid ida =2 m3ntha he choosed to pass preferences
        $events = $_POST["event[]"];

        foreach ($events as $event) {
       switch ($event) {
        // on ajoute au user actuelle les pref et a la session aussi $_SESSION['preferencelist']=$utilisateur['preferencelist'];
                    
                    
            }
        }
        header("Location: bienvenue.php");
        exit();
    }

    
?>


