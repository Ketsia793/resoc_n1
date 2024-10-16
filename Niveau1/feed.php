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
        <title>ReSoC - Flux</title>         
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style/style.css"/>
    </head>
    <body>

        <?php 
        include 'header.php';
        ?>

        <div id="wrapper">
            <?php
             // Etape 1: Le mur concerne un utilisateur en particulier
            $userId = intval($_GET['user_id']);

            // Etape 2: se connecter à la base de donnée
            $mysqli = connectToDatabase();
            ?>
            
            <aside>
                <?php
                // Etape 3: récupérer le nom de l'utilisateur
                $usersInfo = sqlStructure(retrieveUserName($userId), $mysqli);

                $user = $usersInfo->fetch_assoc();
                // echo "<pre>" . print_r($user, 5) . "</pre>";
                ?>
                <img src="images/user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez tous les message des utilisatrices
                        auxquel est abonnée l'utilisatrice <?php echo $user['alias'] ?>
                        (n° <?php echo $userId ?>)
                    </p>

                </section>
            </aside>
            <main>
                <?php
                // Etape 3: récupérer tous les messages des abonnements
                $lesInformations2 = sqlStructure(retrieveFeedPosts($userId), $mysqli);
                
                include 'like.php';
                
                // Etape 4: Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
                while ($post = $lesInformations2->fetch_assoc())
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
