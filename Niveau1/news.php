<?php 
    error_reporting(-1);
    ini_set( 'display_errors', 1 );

    include 'database/connection.php';
    include 'database/retrieve.php';
    include 'database/sql-queries.php';
?>

<?php
session_start();
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Actualités</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style/style.css"/>
    </head>
    <body>
        <?php 
        include 'partials/header.php';
        ?>
        <div id="wrapper">
            <aside>
                <img src="images/user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez les derniers messages de tous les utilisatrices du site.</p>
                </section>
            </aside>
            <main>
                <?php
                    // Etape 1: Ouvrir une connexion avec la base de donnée.
                    $mysqli = connectToDatabase();

                    // Etape 2: Poser une question à la base de donnée et récupérer ses informations
                    $allPosts = sqlStructure(retrieveNewsPosts(), $mysqli);

                    include 'partials/like.php';

                    // Etape 3: A chaque tour du while, la variable post ci dessous reçois les informations du post suivant.
                    while ($post = $allPosts->fetch_assoc()) {
                        // echo "<pre>" . print_r($post, 1) . "</pre>";
                        include 'partials/article.php';
                    }
                ?>
            </main>
        </div>
    </body>
</html>
