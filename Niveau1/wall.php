<?php 
    error_reporting(-1);
    ini_set( 'display_errors', 1 );

    include 'connection.php';
    include 'sql-structure.php';
?>

<?php
session_start();
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Mur</title> 
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <?php 
        include 'header.php';
        ?>
        <div id="wrapper">
            <?php
            // Etape 1: La première étape est de trouver quel est l'id de l'utilisateur, indiqué en parametre GET de la page sous la forme user_id=...
            $userId = intval($_GET['user_id']);
            ?>
            
            <?php
            // Etape 2: se connecter à la base de donnée
            $mysqli = connectToDatabase();
            ?>

            <aside>
                <?php
                // Etape 3: récupérer le nom de l'utilisateur     
                $lesInformations = sqlStructure(retrieveUserName($userId), $mysqli);

                $user = $lesInformations->fetch_assoc();
                //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
                // echo "<pre>" . print_r($user, 1) . "</pre>";
                ?>
                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez tous les message de l'utilisatrice : <?php echo $user['alias'] ?>
                        (n° <?php echo $userId ?>)
                    </p>
                </section>
            </aside>
            <main>
                <?php
                include 'article-creation.php';

                /**
                 * Etape 3: récupérer tous les messages de l'utilisatrice
                 */
                $lesInformations = sqlStructure(retrieveWallPosts($userId), $mysqli);

                // Vérification
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }

                // Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
                while ($post = $lesInformations->fetch_assoc())
                {
                    // echo "<pre>" . print_r($post, 1) . "</pre>";
                    ?>               
                    <?php 
                        include 'article.php';
                    ?>
                <?php } ?>


            </main>
        </div>
    </body>
</html>
