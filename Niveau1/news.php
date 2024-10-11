<?php 
    error_reporting(-1);
    ini_set( 'display_errors', 1 );

    include 'connection.php';
    include 'sql-structure.php';
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Actualités</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <?php 
        include 'header.php';
        ?>
        <div id="wrapper">
            <aside>
                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez les derniers messages de
                        tous les utilisatrices du site.</p>
                </section>
            </aside>
            <main>
                
                <?php
                // Etape 1: Ouvrir une connexion avec la base de donnée.
                $mysqli = connectToDatabase();

                // Etape 2: Poser une question à la base de donnée et récupérer ses informations
                $lesInformations = sqlStructure($retrieveNews, $mysqli);

                // Etape 3: Parcourir ces données et les ranger bien comme il faut dans du html
                // NB: à chaque tour du while, la variable post ci dessous reçois les informations du post suivant.
                while ($post = $lesInformations->fetch_assoc())
                {
                    // echo "<pre>" . print_r($post, 1) . "</pre>";
                    ?>
                    <?php 
                        include 'article.php';
                    ?>
                <?php
                }
                ?>

            </main>
        </div>
    </body>
</html>
