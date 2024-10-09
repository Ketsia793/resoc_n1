<?php 
    // Etape 1: Ouvrir une connexion avec la base de donnée.
    function connect() {
        $mysql = new mysqli("localhost", "root", "", "socialnetwork");
                    
        // Vérification
        if ($mysql->connect_errno)
        {
            echo "<article>";
            echo("Échec de la connexion : " . $mysql->connect_error);
            echo("<p>Indice: Vérifiez les parametres de <code>new mysqli(...</code></p>");
            echo "</article>";
            exit();
        }
        return $mysql;
    }
?>